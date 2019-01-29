<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 1:04
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Shell;

class ShellTest extends VisitTestCase
{
    protected $visitors = [
        Shell::class
    ];

    /**
     * @throws \Exception
     */
    public function testShellExecution()
    {
        $cases = [
            ['`echo $name`;', AlarmLevel::CRITICAL()],
            ['`$prog`;', AlarmLevel::CRITICAL()],
            ['`echo 1234;`;', AlarmLevel::INFO()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, Shell::class);
        }
    }
}