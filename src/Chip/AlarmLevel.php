<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/10
 * Time: 2:57
 */

namespace Chip;


use MyCLabs\Enum\Enum;

/**
 * Class AlarmLevel
 * @package Chip
 * @method static AlarmLevel SAFE()
 * @method static AlarmLevel INFO()
 * @method static AlarmLevel WARNING()
 * @method static AlarmLevel DANGER()
 * @method static AlarmLevel CRITICAL()
 */
class AlarmLevel extends Enum
{
    private const SAFE = 0;

    private const INFO = 1;

    private const WARNING = 2;

    private const DANGER = 3;

    private const CRITICAL = PHP_INT_MAX;
}