<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:15
 */

namespace Chip;

use Chip\Tracer\CallStack;
use PhpParser\Node;

class Pipeline implements \JsonSerializable
{
    /**
     * @var CallStack $callStack
     */
    protected $callStack;

    public function __construct(CallStack $stack)
    {
        parent::__construct([]);
        $this->callStack = $stack;
    }

    public function putMessage($level, $type, $message, Node $node = null)
    {
        $function = $this->callStack->isEmpty() ? null : $this->callStack->top();
        $this[] = new Alarm($level, $type, $message, $node, $function);
    }

    public function info(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::INFO(), $type, $message, $node);
    }

    public function warning(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::WARNING(), $type, $message, $node);
    }

    public function danger(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::DANGER(), $type, $message, $node);
    }

    public function critical(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::CRITICAL(), $type, $message, $node);
    }

    public function safe(Node $node, string $type, string $message)
    {
        $this->putMessage(AlarmLevel::SAFE(), $type, $message, $node);
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
