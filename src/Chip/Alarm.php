<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/10
 * Time: 1:02
 */

namespace Chip;


class Alarm
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

    protected $startLine;

    protected $endLine;

    protected $startPos;

    protected $endPos;

    function __construct(AlarmLevel $level, string $type, string $message, $startLine, $endLine, $startPos, $endPos)
    {
        $this->level = $level;
        $this->message = $message;
        $this->startLine = $startLine;
        $this->endLine = $endLine;
        $this->startPos = $startPos;
        $this->endPos = $endPos;

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

    public function __toString()
    {
        return "{$this->type}:{$this->level->getKey()}:{$this->message}";
    }

    public function __debugInfo()
    {
        return [
            'type' => $this->type,
            'level' => $this->level->getKey(),
            'message' => $this->message
        ];
    }
}