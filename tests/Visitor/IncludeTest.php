<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/16
 * Time: 0:18
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\Include_;

class IncludeTest extends VisitTestCase
{
    protected $visitors = [
        Include_::class
    ];

    /**
     * @throws \Exception
     */
    public function testIncludeVariable()
    {
        $cases = [
            'include $filename; ',
            'include_once $filename; ',
            'require $filename; ',
            'require_once $filename; ',
            'include get_filename(); ',
            'include $this->name; ',
            'include THE_FILENAME; ',
            'InCLUde_ONCE $filename;',
            'require$name;',
            'include"$name";'
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Include_::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testIncludePHPFile()
    {
        $cases = [
            "include '1.php';",
            "include '1.inc';",
            "include \$name . '.php';",
            "include __DIR__ . \$name . '.php';",
            "include __DIR__ . '/' . \$upload_dir . '/' . \$_GET['filename'] . '.php';",
            "include \$_GET[\$file] . '.php';",
            'include "$name.php";',
            'include __DIR__ . "$name.php";',
            'include "$prefix/" . BASE_DIR . "sub_{$name}" . \'.php\';',
            'include get_filename() . \'.php\';'
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(0, $alarms);
        }
    }

    /**
     * @throws \Exception
     */
    public function testDangerExtension()
    {
        $cases = [
            'include "abc";',
            'include "1.gif";',
            "include __DIR__ . '/index.html';"
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Include_::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testIncludeDynamicExtension()
    {
        $cases = [
            "include \$name . '.' . \$ext;",
            'include "filename.$ext";',
            'include "1" . EXT; ',
            'include __DIR__ . "/{$this->name}.{$this->ext}";'
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Include_::class);
        }
    }

    /**
     * @throws \Exception
     */
    public function testIncludeDynamicString()
    {
        $cases = [
            "include base64_decode(\$_GET['s']); ",
            'include $a.$b.$c.$d.$e.$f."$d".\'1\'.$x.$y.$z;',
            'include((((($a).$b).$c).$d).$f.(\'/\'.((($x).$y).$z)));'
        ];

        foreach ($cases as $code) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), Include_::class);
        }
    }
}