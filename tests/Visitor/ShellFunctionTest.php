<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 1:10
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\ShellFunction;

class ShellFunctionTest extends VisitTestCase
{
    protected $visitors = [
        ShellFunction::class
    ];

    /**
     * @throws \Exception
     */
    public function testShellFunction()
    {
        $cases = [
            ['echo shell_exec($command);', AlarmLevel::CRITICAL()],
            ['\shell_exec($command);', AlarmLevel::CRITICAL()],
            ['SYStem($command);', AlarmLevel::CRITICAL()],
            ['exec($command, $ret);', AlarmLevel::CRITICAL()],
            ['passthru($command);', AlarmLevel::CRITICAL()],
            ['popen($command, "r");', AlarmLevel::CRITICAL()],
            ['$process = proc_open($prog, $descriptorspec, $pipes, $cwd, $env);', AlarmLevel::CRITICAL()],
            ['shell_exec("echo $command");', AlarmLevel::CRITICAL()],
            ['shell_exec(\'echo \' . $command);', AlarmLevel::CRITICAL()],
            ['echo shell_exec(base64_decode($_REQUEST["cmd"]));', AlarmLevel::CRITICAL()],
            ['echo shell_exec("ls -al");', AlarmLevel::INFO()],
            ['echo shell_exec(...$this);', AlarmLevel::CRITICAL()]
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, ShellFunction::class);
        }
    }
}