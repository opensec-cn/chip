<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/10
 * Time: 1:02
 */

namespace Chip;

use PhpParser\Node;

class Alarm implements \JsonSerializable
{
    /**
     * @var string $type
     */
    protected $type;

    /**
     * @type AlarmLevel $level
     * enum
     */
    protected $level;

    /**
     * @type string $message
     */
    protected $message;

    /**
     * @var Node $node
     */
    protected $node;

    /**
     * @var Node $function
     */
    protected $function;

    public function __construct(AlarmLevel $level, string $type, string $message, Node $node = null, Node $function = null)
    {
        $this->level = $level;
        $this->message = $message;

        $this->node = $node;
        $this->function = $function;

        $type = explode('\\', $type);
        $this->type = end($type);
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

    public function getLevel()
    {
        return $this->level;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getNode()
    {
        return $this->node;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function lineRange()
    {
        return [$this->node->getStartLine(), $this->node->getEndLine()];
    }

    public function __toString()
    {
        return "{$this->type}:{$this->level->getKey()}:{$this->message}";
    }

    public function __debugInfo()
    {
        return [
            'type'    => $this->type,
            'level'   => $this->level->getKey(),
            'message' => $this->message,
        ];
    }

    public function jsonSerialize()
    {
        return $this->__debugInfo();
    }

    public function formatOutput(string $code)
    {
        $code = explode("\n", $code);
        $vulnerability = [
            'level'     => $this->getLevel()->getKey(),
            'message'   => $this->getMessage(),
            'code'      => $code,
            'highlight' => [],
        ];

        $node = $this->getNode();
        $function = $this->getFunction();

        if (!$node) {
            return $vulnerability;
        }

        list($nodeStartLine, $nodeEndLine) = [$node->getStartLine(), $node->getEndLine()];

        if ($function) {
            list($functionStartLine, $functionEndLine) = [$function->getStartLine(), $function->getEndLine()];
        } else {
            list($functionStartLine, $functionEndLine) = [max($nodeStartLine - 5, 1), $nodeEndLine + 5];
        }

        $code = array_slice($code, $functionStartLine - 1, $functionEndLine - $functionStartLine + 1);
        $start = $functionStartLine;

        array_map(function ($key) use ($start, $nodeStartLine, $nodeEndLine, &$vulnerability) {
            $startKey = $start + $key;

            if ($nodeStartLine <= $startKey && $startKey <= $nodeEndLine) {
                $vulnerability['highlight'][] = $startKey;
            }
        }, array_keys($code));

        return $vulnerability;
    }
}
