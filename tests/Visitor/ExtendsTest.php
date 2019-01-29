<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 2:00
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Extends_;

class ExtendsTest extends VisitTestCase
{
    protected $visitors = [
        Extends_::class
    ];

    /**
     * @throws \Exception
     */
    public function testEvilExtends()
    {
        $cases = [
            "class UserClass extends ReflectionMethod {\n}",
            "class UserClass extends reFlectioNmethOD {\n}",
            "class UserClass extends ReflectionZendExtension {\n}",
            "class UserClass extends \ReflectionExtension {\n}",
            "class UserClass extends ReflectionFunction {\n}",
            "class UserClass extends ReflectionFunctionAbstract {\n}",
            "class UserClass extends ReflectionClass {\n}",
            "class UserClass extends ReflectionGenerator {\n}",
            "\$f = new class('create_function') extends ReflectionFunction {};",
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Extends_::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafeExtends()
    {
        $this->assertEmpty($this->detectCode('class UserClass extends StdClass {}'));
        $this->assertEmpty($this->detectCode('class ReflectionFunction {}'));
        $this->assertEmpty($this->detectCode('new class(\'create_function\') extends StdClass {};'));
        $this->assertEmpty($this->detectCode('new class(\'create_function\') {};'));
    }
}