<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/27
 * Time: 2:57
 */

namespace Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Assert_;

class AssertTest extends VisitTestCase
{
    protected $visitors = [
        Assert_::class
    ];

    /**
     * @throws \Exception
     */
    public function testAssert()
    {
        $cases = [
            ['assert($code);', AlarmLevel::CRITICAL()],
            ['AssERT($code);', AlarmLevel::CRITICAL()],
            ["assert('phpinfo();');", AlarmLevel::WARNING()],
            ['assert("eval(" . $_GET["i"] . ");");', AlarmLevel::CRITICAL()],
            ['assert("\$r = {$code};");', AlarmLevel::CRITICAL()],
            ["use function assert as test;\n\ntest('phpinfo();');", AlarmLevel::WARNING()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, Assert_::class);
        }
    }

    /**
     * @expectedException \Chip\Exception\FormatException
     */
    public function testWrongAssert()
    {
        $this->detectCode('assert();');
    }
}