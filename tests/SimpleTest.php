<?php
namespace Chip\Tests;

use Chip\Alarm;
use Chip\AlarmLevel;
use Chip\ChipFactory;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testSimple()
    {
        $code = '<?php usort($g1, $g2);';
        $chipManager = (new ChipFactory)->create();
        $alarms = $chipManager->detect($code);

        $this->assertGreaterThan(0, count($alarms));

        $alarm = $alarms[0];
        $this->assertInstanceOf(Alarm::class, $alarm);
        $this->assertEquals(AlarmLevel::DANGER(), $alarm->level);
        $this->assertEquals('Callback_', $alarm->type);
    }
}
