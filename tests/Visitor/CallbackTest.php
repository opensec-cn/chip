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
use Chip\Visitor\FilterVar;

class CallbackTest extends VisitTestCase
{
    protected $visitors = [
        Callback_::class,
        FilterVar::class
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
            "register_tick_function(\$e, \$_REQUEST['pass']);",
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Callback_::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testVarFilter()
    {
        $cases = [
            ["filter_var(\$_REQUEST['pass'], FILTER_CALLBACK, \$option);", AlarmLevel::DANGER()],
            ["filter_var(\$_REQUEST['pass'], 1024, \$option);", AlarmLevel::DANGER()],
            ["filter_var(\$_REQUEST['pass'], 0x200, \$option);", AlarmLevel::DANGER()],
            ["filter_var(\$_REQUEST, \$filter, \$option);", AlarmLevel::DANGER()],
            ['filter_var($_REQUEST, $filter, $option);', AlarmLevel::DANGER()],
            ['filter_var($_REQUEST, FILTER_CALLBACK, test());', AlarmLevel::DANGER()],
            ["filter_var(\$_REQUEST['pass'], FILTER_CALLBACK, array('options' => 'assert'));", AlarmLevel::WARNING()],
            ["filter_var(\$_REQUEST['pass'], FILTER_CALLBACK, [\$k => 'assert']);", AlarmLevel::WARNING()],
            ["filter_var(\$_REQUEST['pass'], FILTER_CALLBACK, array('options' => \$f));", AlarmLevel::WARNING()],
            ["filter_var_array(array('test' => \$_REQUEST['pass']), array('test' => array('filter' => FILTER_CALLBACK, 'options' => 'assert')));", AlarmLevel::WARNING()],
            ["filter_var_array(\$_REQUEST, \$option);", AlarmLevel::DANGER()],
            ["filter_var_array(\$_REQUEST, THIS_IS_A_CONST);", AlarmLevel::DANGER()],
            ["filter_var_array(array('test' => \$_REQUEST['pass']), array('test' => array('filter' => 0x200, 'options' => \$code)));", AlarmLevel::WARNING()],
            ["filter_var_array(\$_POST, ['test' => [\$k => 0x200, 'options' => \$code]]);", AlarmLevel::WARNING()],
            ["filter_var_array(\$_POST, ['test' => test()]);", AlarmLevel::WARNING()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, FilterVar::class);
        }

        $cases = [
            "filter_var('0755', FILTER_VALIDATE_INT, \$options);",
            "\$var = filter_var('oops', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);",
            "\$var = filter_var('oops', FILTER_VALIDATE_BOOLEAN,
                  array('flags' => FILTER_NULL_ON_FAILURE));",
            'filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED);',
            '$result = filter_var($url, FILTER_VALIDATE_URL);',
            'filter_var($email_a, FILTER_VALIDATE_EMAIL);',
            'filter_var($email_a, FILTER_CALLBACK, FILTER_VALIDATE_EMAIL | FILTER_VALIDATE_IP);',
            'function is_private_ip($ip) {
  return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE); 
} ',
            'echo filter_var($InjString, FILTER_SANITIZE_EMAIL);',
            'filter_var($_REQUEST, $filter, array());',
            "filter_var(\$_REQUEST, FILTER_CALLBACK, ['options' => function() {}]);",
            "filter_var_array(\$_REQUEST, ['test' => ['options' => 'assert']]);",
            "filter_var_array(\$_REQUEST, ['test' => array('filter'    => FILTER_VALIDATE_INT,
                            'flags'     => FILTER_FORCE_ARRAY,
                            'options'   => array('min_range' => 1, 'max_range' => 10)
                           )]);",
            "filter_var_array(\$_REQUEST, ['test' => FILTER_SANITIZE_ENCODED]);",
            "filter_var_array(\$_REQUEST, array('test' => array('filter' => 0x200)));",
            '$myinputs = filter_var_array($data,FILTER_SANITIZE_STRING); '
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(0, $alarms);
        }
    }
}
