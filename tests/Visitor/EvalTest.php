<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 0:13
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Eval_;

class EvalTest extends VisitTestCase
{
    protected $visitors = [
        Eval_::class
    ];

    /**
     * @throws \Exception
     */
    public function testEval()
    {
        $cases = [
            ['eval($code);', AlarmLevel::CRITICAL()],
            ['eVal($code);', AlarmLevel::CRITICAL()],
            ['eval(base64_decode($code));', AlarmLevel::CRITICAL()],
            ['eval(SOMETHING);', AlarmLevel::CRITICAL()],
            ["eval('ret = ' . \$ret . ';');", AlarmLevel::CRITICAL()],
            ['eval("ret = $ret;");', AlarmLevel::CRITICAL()],
            ['eval("ret = \$ret;");', AlarmLevel::WARNING()],
            ['eval("eval(\$_POST[2333]);");', AlarmLevel::WARNING()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, Eval_::class);
        }
    }
}