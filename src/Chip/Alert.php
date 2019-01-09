<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/10
 * Time: 1:02
 */

namespace Chip;


class Alert
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

    public static function warning(string $message): Alert
    {
        return new self(AlarmLevel::WARNING(), $message);
    }

    public static function danger(string $message): Alert
    {
        return new self(AlarmLevel::DANGER(), $message);
    }

    public static function critical(string $message): Alert
    {
        return new self(AlarmLevel::CRITICAL(), $message);
    }

    public static function safe(string $message): Alert
    {
        return new self(AlarmLevel::SAFE(), $message);
    }
}