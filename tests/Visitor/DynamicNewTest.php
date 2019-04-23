<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 1:55
 */

namespace Chip\Tests\Visitor;

use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\DynamicNew;

class DynamicNewTest extends VisitTestCase
{
    protected $visitors = [
        DynamicNew::class
    ];

    /**
     * @throws \Exception
     */
    public function testDynamicNew()
    {
        $cases = [
            'new $class();',
            'new $class;',
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::WARNING(), DynamicNew::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeNew()
    {
        $this->assertEmpty($this->detectCode('new StdClass;'));
        $this->assertEmpty($this->detectCode('new StdClass();'));
        $this->assertEmpty($this->detectCode('$class = new class([1,2,3]) extends \SplArray {};'));
    }
}
