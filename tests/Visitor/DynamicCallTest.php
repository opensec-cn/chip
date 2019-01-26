<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/26
 * Time: 1:39
 */

namespace Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\DynamicCall;

class DynamicCallTest extends VisitTestCase
{
    protected $visitors = [
        DynamicCall::class
    ];

    /**
     * @throws \Exception
     */
    public function testCallFunction()
    {
        $cases = [
            ['$f();', AlarmLevel::DANGER()],
            ["('phpinfo')();", AlarmLevel::WARNING()],
            ["('php'.'info')();", AlarmLevel::WARNING()],
            ['$r = "${$a()}";', AlarmLevel::DANGER()],
            ["\$f\n\n\n\n\r\t\t\t\t(...\$_GET);", AlarmLevel::DANGER()],
            ['(F)();', AlarmLevel::DANGER()],
            ['(base64_decode("abcd"))();', AlarmLevel::DANGER()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, DynamicCall::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeCalling()
    {
        $cases = [
            'phpinfo();',
            '\A\B\C();',
            'A\B();',
            'test(...$_GET);',
            '$a;b();'
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(0, $alarms);
        }
    }
}