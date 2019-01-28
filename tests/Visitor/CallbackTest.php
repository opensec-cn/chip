<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-28
 * Time: 18:16
 */

namespace Chip\Tests\Visitor;

use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Callback_;

class CallbackTest extends VisitTestCase
{
    protected $visitors = [
        Callback_::class
    ];

    /**
     * @throws \Exception
     */
    public function testCallbackFunctions()
    {
        $cases = [
            "call_user_func(\$f);",
            "call_user_func_array(\$_REQUEST['f'], [1, 2, 3]);",
            'array_filter([], base64_decode($e));',
            'array_map(base64_decode($e), []);',
            'uasort([], $e);',
            'uksort([], $e);',
            'usort([], $e);',
            "array_reduce(\$arr, \$e, \$_POST['pass']);",
            'array_udiff($arr, $arr2, $e);',
            "array_walk(\$arr, \$e, '');",
            "array_walk_recursive(\$arr, \$e, '');",
            'ob_start($callback);',
            "register_shutdown_function(\$e, \$_REQUEST['pass']);",
            "register_tick_function(\$e, \$_REQUEST['pass']);"
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Callback_::class);
        }
    }
}
