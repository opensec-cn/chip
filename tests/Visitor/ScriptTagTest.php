<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/4/22
 * Time: 0:46
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\ScriptTag;

class ScriptTagTest extends VisitTestCase
{
    protected $visitors = [
        ScriptTag::class
    ];

    /**
     * @param string $code
     * @throws \Exception
     */
    private function isDanger(string $code)
    {
        $alarms = $this->chipManager->detect($code);
        $this->assertCount(1, $alarms);
        $this->assertHasAlarm($alarms[0], AlarmLevel::WARNING(), ScriptTag::class);
    }

    /**
     * @throws \Exception
     */
    public function testScriptTag()
    {
        $this->isDanger('<script language="php">danger;</script>');
        $this->isDanger('<script language  =   "php">danger;</script>');
        $this->isDanger('<script language="pHP">danger;</script>');
        $this->isDanger('<script lanGuaGE="php">danger;</script>');
        $this->isDanger('<ScRiPT lanGuaGE="php">danger;</ScRiPT>');
        $this->isDanger('<script lanGuaGE="PhP">danger;');
        $this->isDanger('</script><script lanGuaGE="PhP">danger;');
        $this->isDanger('<script><script lanGuaGE="PhP">danger;');
        $this->isDanger('aaaa<script>aaaa<script>aaaazz<script><script lanGuaGE="PhP">danger;');
        $this->isDanger('<script language="php">danger;</script');
        $this->isDanger('<script language=php>danger;</script>');
        $this->isDanger('<script language=\'php\'>danger;</script>');
        $this->isDanger('<script language= php    >danger;</script>');
        $this->isDanger('<script language= 
php
>danger;</script>');

        $this->assertEmpty($this->chipManager->detect('<script>safe;</script>'));
        $this->assertEmpty($this->chipManager->detect('xxxx'));
        $this->assertEmpty($this->chipManager->detect('<script lang="php">safe;</script>'));
        $this->assertEmpty($this->chipManager->detect('<script language="">safe;</script>'));
        $this->assertEmpty($this->chipManager->detect('<script language="ph
p">safe;</script>'));
    }
}