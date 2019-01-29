<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 2:32
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\MbPregExec;
use Chip\Visitor\PregExec;

class PregExecTest extends VisitTestCase
{
    protected $visitors = [
        PregExec::class,
        MbPregExec::class,
    ];

    /**
     * @throws \Exception
     */
    public function testPregExec()
    {
        $cases = [
            'preg_replace($a, $b, $c);',
            '\Preg_RepLace($a, $b, $c);',
            'preg_replace("/abc{$p}/i", $b, $c);',
            'preg_replace("/.*/ie", $b, $c);',
            'preg_replace("#.*#e", $b, $c);',
            'preg_replace(base64_decode($_GET[2333]), $b, $c);',
            'preg_filter($a, $b, $c);',
            'preg_filter("/.*/ie", $b, $c);',
            "echo preg_filter('|.*|e', \$_REQUEST['pass'], '');",
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), PregExec::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testMbPregExec()
    {
        $cases = [
            'mb_ereg_replace($a, $b, $c, $d);',
            '\MB_ereg_REplace($a, $b, $c, $d);',
            'mb_ereg_replace(".*", $b, $c, "i" . $d);',
            'mb_ereg_replace(".*", $b, $c, "e");',
            'mb_ereg_replace(".*", $b, $c, e);',
            'mb_eregi_replace($a, $b, $c, $d);',
            'mb_eregi_replace(".*", $b, $c, "e");',
            "mb_ereg_replace('.*', \$_REQUEST['pass'], '', 'e');",
            'mb_regex_set_options("ies");',
            'mb_regex_set_options($options);',
            'mb_regex_set_options(base64_decode($_GET["options"]));',
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), MbPregExec::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testSafePreg()
    {
        $this->assertEmpty($this->detectCode("preg_replace('/[a-z]+/i', '', \$data);"));
        $this->assertEmpty($this->detectCode("preg_filter('/[a-z]+/i', '', \$data);"));
        $this->assertEmpty($this->detectCode("mb_ereg_replace('[a-z]+', '', \$data);"));
        $this->assertEmpty($this->detectCode("mb_eregi_replace('[a-z]+', '', \$data);"));
        $this->assertEmpty($this->detectCode("mb_ereg_replace('[a-z]+', '', \$data, '');"));
        $this->assertEmpty($this->detectCode("mb_ereg_replace('[a-z]+', '', \$data, 'msr');"));
        $this->assertEmpty($this->detectCode("mb_regex_set_options();"));
        $this->assertEmpty($this->detectCode("mb_regex_set_options('is');"));
    }
}