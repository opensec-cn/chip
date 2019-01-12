<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:15
 */

namespace Chip;

use PhpParser\Node;

class Message
{
    /**
     * @type array $alarm
     */
    public static $alarm = [];

    protected static function getPositions(Node $node)
    {
        return [
            $node->getStartLine(),
            $node->getEndLine(),
            $node->getStartFilePos(),
            $node->getEndFilePos()
        ];
    }

    protected static function putMessage($node, $level, $message)
    {
        $positions = self::getPositions($node);
        self::$alarm[] = new Alarm($level, $message, ...$positions);
    }

    public static function info(Node $node, string $message)
    {
        self::putMessage($node, AlarmLevel::INFO(), $message);
    }

    public static function warning(Node $node, string $message)
    {
        self::putMessage($node, AlarmLevel::WARNING(), $message);
    }

    public static function danger(Node $node, string $message)
    {
        self::putMessage($node, AlarmLevel::DANGER(), $message);
    }

    public static function critical(Node $node, string $message)
    {
        self::putMessage($node, AlarmLevel::CRITICAL(), $message);
    }

    public static function safe(Node $node, string $message)
    {
        self::putMessage($node, AlarmLevel::SAFE(), $message);
    }
}