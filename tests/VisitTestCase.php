<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/16
 * Time: 1:50
 */

namespace Chip\Tests;


use Chip\Alarm;
use Chip\AlarmLevel;
use Chip\ChipManager;
use PHPUnit\Framework\TestCase;

class VisitTestCase extends TestCase
{
    /**
     * @var ChipManager $chipManager
     */
    protected $chipManager;

    /**
     * @var array $visitors
     */
    protected $visitors = [];

    function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->chipManager = new ChipManager();

        foreach ($this->visitors as $visitor) {
            $this->chipManager->addVisitor($visitor);
        }
    }

    protected function detectCode(string $code)
    {
        $code = '<?php' . "\n" . $code;
        return $this->chipManager->detect($code);
    }

    public function assertHasAlarm(Alarm $alarm, AlarmLevel $level, string $type)
    {
        $_types = explode('\\', $type);
        $type = end($_types);

        $this->assertSame($alarm->getType(), $type);
        $this->assertSame($alarm->getLevel()->getValue(), $level->getValue());
    }
}