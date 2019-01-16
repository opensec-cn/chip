<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:15
 */

namespace Chip;

use PhpParser\Node;

class Message extends \ArrayObject implements \JsonSerializable
{
    function __construct()
    {
        parent::__construct([]);
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

    protected function putMessage($node, $level, $type, $message)
    {
        $positions = $this->getPositions($node);
        $this[] = new Alarm($level, $type, $message, ...$positions);
    }

    public function info(Node $node, string $type, string $message)
    {
        $this->putMessage($node, AlarmLevel::INFO(), $type, $message);
    }

    public function warning(Node $node, string $type, string $message)
    {
        $this->putMessage($node, AlarmLevel::WARNING(), $type, $message);
    }

    public function danger(Node $node, string $type, string $message)
    {
        $this->putMessage($node, AlarmLevel::DANGER(), $type, $message);
    }

    public function critical(Node $node, string $type, string $message)
    {
        $this->putMessage($node, AlarmLevel::CRITICAL(), $type, $message);
    }

    public function safe(Node $node, string $type, string $message)
    {
        $this->putMessage($node, AlarmLevel::SAFE(), $type, $message);
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}