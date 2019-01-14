<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:15
 */

namespace Chip;

use PhpParser\Node;

class Message
{
    /**
     * @type array $alarm
     */
    public $alarm;

    function __construct()
    {
        $this->alarm = [];
    }

    protected function getPositions(Node $node)
    {
        return [
            $node->getStartLine(),
            $node->getEndLine(),
            $node->getStartFilePos(),
            $node->getEndFilePos()
        ];
    }

    protected function putMessage($node, $level, $message)
    {
        $positions = $this->getPositions($node);
        $this->alarm[] = new Alarm($level, $message, ...$positions);
    }

    public function info(Node $node, string $message)
    {
        $this->putMessage($node, AlarmLevel::INFO(), $message);
    }

    public function warning(Node $node, string $message)
    {
        $this->putMessage($node, AlarmLevel::WARNING(), $message);
    }

    public function danger(Node $node, string $message)
    {
        $this->putMessage($node, AlarmLevel::DANGER(), $message);
    }

    public function critical(Node $node, string $message)
    {
        $this->putMessage($node, AlarmLevel::CRITICAL(), $message);
    }

    public function safe(Node $node, string $message)
    {
        $this->putMessage($node, AlarmLevel::SAFE(), $message);
    }
}