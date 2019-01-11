<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:15
 */

namespace Chip;

class Message
{
    /**
     * @type array $alarm
     */
    public static $alarm = [];

    public static function warning(string $message)
    {
        self::$alarm[] = new Alarm(AlarmLevel::WARNING(), $message);
    }

    public static function danger(string $message)
    {
        self::$alarm[] = new Alarm(AlarmLevel::DANGER(), $message);
    }

    public static function critical(string $message)
    {
        self::$alarm[] = new Alarm(AlarmLevel::CRITICAL(), $message);
    }

    public static function safe(string $message)
    {
        self::$alarm[] = new Alarm(AlarmLevel::SAFE(), $message);
    }
}