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
    public $type;

    /**
     * @type AlarmLevel $level
     * enum
     */
    public $level;

    /**
     * @type string $message
     */
    public $message;

    /**
     * @var Node $node
     */
    protected $node;

    /**
     * @var Node\Stmt\Function_|Node\Stmt\ClassMethod $function
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

    public function getStartFilePos()
    {
        return $this->node->getStartFilePos();
    }

    public function getEndFilePos()
    {
        return $this->node->getEndFilePos();
    }

    public function getStartLine()
    {
        return $this->node->getStartLine();
    }

    public function getEndLine()
    {
        return $this->node->getEndLine();
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
            'level'    => strtolower($this->getLevel()->getKey()),
            'message'  => $this->getMessage(),
            'lines'    => [],
            'function' => '',
        ];

        $node = $this->getNode();
        $function = $this->getFunction();

        if (!$node) {
            list($nodeStartLine, $nodeEndLine) = [1, count($code)];
            list($functionStartLine, $functionEndLine) = [$nodeStartLine, $nodeEndLine];
        } else {
            list($nodeStartLine, $nodeEndLine) = [$node->getStartLine(), $node->getEndLine()];

            if ($function) {
                list($functionStartLine, $functionEndLine) = [$function->getStartLine(), $function->getEndLine()];
                $vulnerability['function'] = strval($function->name);
            } else {
                list($functionStartLine, $functionEndLine) = [max($nodeStartLine - 5, 1), $nodeEndLine + 5];
            }
        }

        $code = array_slice($code, $functionStartLine - 1, $functionEndLine - $functionStartLine + 1);
        $start = $functionStartLine;

        array_map(function ($key, $line) use ($start, $nodeStartLine, $nodeEndLine, &$vulnerability) {
            $startKey = $start + $key;

            $highlight = $nodeStartLine <= $startKey && $startKey <= $nodeEndLine;
            $vulnerability['lines'][] = [$startKey, $line, $highlight];
        }, array_keys($code), $code);

        return $vulnerability;
    }
}
