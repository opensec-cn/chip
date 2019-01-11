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

    function __construct(AlarmLevel $level, string $message)
    {
        $this->lavel = $level;
        $this->message = $message;
    }
}