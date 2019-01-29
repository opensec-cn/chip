<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 3:04
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\StaticCallback;

class StaticCallbackTest extends VisitTestCase
{
    protected $visitors = [
        StaticCallback::class
    ];

    /**
     * @throws \Exception
     */
    public function testStaticCallback()
    {
        $cases = [
            ['$phar = Phar::webPhar($a, $b, $c, $d, $e);', AlarmLevel::DANGER()],
            ['$phar = Phar::webPhar($a, $b, $c, $d, foo());', AlarmLevel::DANGER()],
            ['$phar = Phar::webPhar($a, $b, $c, $d, "assert");', AlarmLevel::WARNING()],
            ['$f = Closure::fromCallable($_REQUEST["f"]);', AlarmLevel::DANGER()],
            ['$f = Closure::fromCallable(\'assert\');', AlarmLevel::WARNING()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, StaticCallback::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeStaticCallback()
    {
        $this->assertEmpty($this->detectCode('$phar = Phar::webPhar();'));
    }
}