<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/30
 * Time: 3:11
 */

namespace Chip\Tests\Visitor;


use Chip\AlarmLevel;
use Chip\Tests\VisitTestCase;
use Chip\Visitor\MethodCallback;

class MethodCallbackTest extends VisitTestCase
{
    protected $visitors = [
        MethodCallback::class
    ];

    /**
     * @throws \Exception
     */
    public function testMethodCallback()
    {
        $cases = [
            ['$f->uasort($callback);', AlarmLevel::DANGER()],
            ['$f->uASort("assert");', AlarmLevel::WARNING()],
            ['$f->uksort($callback);', AlarmLevel::DANGER()],
            ['$db->set_local_infile_handler($callback);', AlarmLevel::DANGER()],
            ['$db->sqliteCreateAggregate("udf", function() {}, $c2);', AlarmLevel::DANGER()],
            ['$db->sqliteCreateAggregate("udf", $c1, function() {});', AlarmLevel::DANGER()],
            ['$db->sqliteCreateCollation("udf", $callback);', AlarmLevel::DANGER()],
            ['$db->sqliteCreateCollation("udf", "assert");', AlarmLevel::WARNING()],
            ['$db->sqliteCreateCollation(...$_POST);', AlarmLevel::DANGER()],
            ['$db->sqliteCreateFunction("udf", $callback);', AlarmLevel::DANGER()],
            ['$db->createCollation("udf", $callback);', AlarmLevel::DANGER()],
            ['$s->fetchAll(PDO::FETCH_FUNC, $callback);', AlarmLevel::DANGER()],
            ['$s->fetchAll(PDO::FETCH_FUNC, "assert");', AlarmLevel::WARNING()],
            ['$s->fetchAll(...$_POST);', AlarmLevel::DANGER()],
            ['$db->createFunction("udf", $callback);', AlarmLevel::DANGER()],
        ];

        foreach ($cases as [$code, $level]) {
            $alarms = $this->detectCode($code);
            $this->assertCount(1, $alarms);
            $this->assertHasAlarm($alarms[0], $level, MethodCallback::class);
        }

        $alarms = $this->detectCode('$db->sqliteCreateAggregate("udf", $c1, $c2);');
        $this->assertCount(2, $alarms);
        $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), MethodCallback::class);

        $alarms = $this->detectCode('$db->sqliteCreateAggregate("udf", ...$arr);');
        $this->assertCount(2, $alarms);
        $this->assertHasAlarm($alarms[0], AlarmLevel::DANGER(), MethodCallback::class);
    }

    /**
     * @throws \Exception
     */
    public function testSafeCallback()
    {
        $this->assertEmpty($this->detectCode('$f->sqliteCreateAggregate("udf", function() {}, function() {});'));
        $this->assertEmpty($this->detectCode('$s->fetchAll(PDO::FETCH_COLUMN, 0);'));
        $this->assertEmpty($this->detectCode('$s->fetchAll(7, 0);'));
        $this->assertEmpty($this->detectCode('$s->fetchAll(PDO::FETCH_FUNC, function() {});'));
        $this->assertEmpty($this->detectCode('$s->fetchAll();'));
    }
}