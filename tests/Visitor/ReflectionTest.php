<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 2:59
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Reflection;

class ReflectionTest extends VisitTestCase
{
    protected $visitors = [
        Reflection::class
    ];

    /**
     * @throws \Exception
     */
    public function testReflection()
    {
        $cases = [
            'new ReflectionClass($class);',
            'new ReflectionZendExtension;',
            'new ReflectionExtension;',
            'new ReflectionFunction($name);',
            'new ReflectionFunctionAbstract;',
            'new ReflectionMethod;',
            'new ReflectionGenerator;',
            'new \reFlectionfUnction($name);',
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::WARNING(), Reflection::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafe()
    {
        $this->assertEmpty($this->detectCode('new User\ReflectionFunction($name);'));
    }
}