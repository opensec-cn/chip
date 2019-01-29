<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/29
 * Time: 23:49
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Exception\ArgumentsFormatException;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\CreateFunction;

class CreateFunctionTest extends VisitTestCase
{
    protected $visitors = [
        CreateFunction::class
    ];

    /**
     * @throws \Exception
     */
    public function testCreateFunction()
    {
        $cases = [
            ['create_function($args, $code);', AlarmLevel::CRITICAL()],
            ['\create_function($args, $code);', AlarmLevel::CRITICAL()],
            ['crEate_FuncTion($args, $code);', AlarmLevel::CRITICAL()],
            ["create_function('', \$code);", AlarmLevel::CRITICAL()],
            ["create_function(\$args, 'return true;');", AlarmLevel::CRITICAL()],
            ["create_function('\$arg', 'return \$arg * 2;');", AlarmLevel::WARNING()],
            ["create_function('\$a, ' . \$b, 'return true;');", AlarmLevel::CRITICAL()],
            ["create_function(\"\$a\", 'return true;');", AlarmLevel::CRITICAL()],
            ["create_function(test(), 'return true;');", AlarmLevel::CRITICAL()],
            ["create_function('', test());", AlarmLevel::CRITICAL()],
            ["create_function('', \"return \$arg;\");", AlarmLevel::CRITICAL()],
            ["create_function('\$arg', 'return \$arg + ' . \$_GET['n'] . ';');", AlarmLevel::CRITICAL()]
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, CreateFunction::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeCreateFunction()
    {
        $this->assertCount(0, $this->detectCode('\user\create_function($args, $code);'));
    }

    /**
     * @throws \Exception
     */
    public function testException()
    {
        try {
            $this->detectCode('create_function($code);');
            throw new \Exception;
        } catch (\Exception $e) {
            $this->assertInstanceOf(ArgumentsFormatException::class, $e);
        }
    }
}