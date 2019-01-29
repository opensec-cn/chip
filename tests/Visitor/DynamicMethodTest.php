<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 1:47
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\DynamicMethod;

class DynamicMethodTest extends VisitTestCase
{
    protected $visitors = [
        DynamicMethod::class
    ];

    /**
     * @throws \Exception
     */
    public function testDynamicMethod()
    {
        $cases = [
            ['$this->$name();', AlarmLevel::DANGER()],
            ['$this->{base64_decode($_GET[2333])}();', AlarmLevel::DANGER()],
            ['$this->{USER_CONST}();', AlarmLevel::DANGER()],
            ["\$this->{'run'}();", AlarmLevel::WARNING()],
            ["\$this->{'run' . \$name}();", AlarmLevel::DANGER()],
            ["\$this->{'ex' . 'ec'}(\$command);", AlarmLevel::WARNING()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, DynamicMethod::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeMethod()
    {
        $this->assertEmpty($this->detectCode('$this->something();'));
    }
}