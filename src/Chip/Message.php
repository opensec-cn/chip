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
    public function __construct()
    {
        parent::__construct([]);
    }

    protected function getPositions(Node $node)
    {
        return [
            $node->getStartLine(),
            $node->getEndLine(),
            $node->getStartFilePos(),
            $node->getEndFilePos(),
        ];
    }

    public function putMessage($level, $type, $message, ...$positions)
    {
        $this[] = new Alarm($level, $type, $message, ...$positions);
    }

    public function info(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::INFO(), $type, $message, ...$this->getPositions($node));
    }

    public function warning(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::WARNING(), $type, $message, ...$this->getPositions($node));
    }

    public function danger(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::DANGER(), $type, $message, ...$this->getPositions($node));
    }

    public function critical(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::CRITICAL(), $type, $message, ...$this->getPositions($node));
    }

    public function safe(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::SAFE(), $type, $message, ...$this->getPositions($node));
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
