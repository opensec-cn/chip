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
     * @type AlarmLevel $level
     * enum
     */
    protected $lavel;

    /**
     * @type string $message
     */
    protected $message;

    protected $startLine;

    protected $endLine;

    protected $startPos;

    protected $endPos;

    function __construct(AlarmLevel $level, string $message, $startLine, $endLine, $startPos, $endPos)
    {
        $this->lavel = $level;
        $this->message = $message;
        $this->startLine = $startLine;
        $this->endLine = $endLine;
        $this->startPos = $startPos;
        $this->endPos = $endPos;
    }
}