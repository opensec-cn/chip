<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 2:14
 */

namespace Chip\Tests\Visitor;

use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\DynamicStaticMethod;

class DynamicStaticMethodTest extends VisitTestCase
{
    protected $visitors = [
        DynamicStaticMethod::class
    ];

    /**
     * @throws \Exception
     */
    public function testDynamicStaticMethod()
    {
        $cases = [
            ['$class::bar();', AlarmLevel::DANGER()],
            ['foo()::bar();', AlarmLevel::DANGER()],
            ['Foo::$bar();', AlarmLevel::DANGER()],
            ["self::{'bar' . \$name}();", AlarmLevel::DANGER()],
            ["(\$foo . 'action')::bar();", AlarmLevel::DANGER()],
            ["static::{'bar'}();", AlarmLevel::WARNING()],
            ["('foo')::bar();", AlarmLevel::WARNING()],
            ["('foo')::{base64_decode('YmFy')}();", AlarmLevel::DANGER()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, DynamicStaticMethod::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeStaticMethod()
    {
        $this->assertEmpty($this->detectCode('static::test();'));
        $this->assertEmpty($this->detectCode('self::test();'));
        $this->assertEmpty($this->detectCode('FOO::BAR();'));
    }
}
