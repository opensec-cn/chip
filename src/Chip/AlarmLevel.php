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
 *
 * @package Chip
 * @method  static AlarmLevel SAFE()
 * @method  static AlarmLevel INFO()
 * @method  static AlarmLevel WARNING()
 * @method  static AlarmLevel DANGER()
 * @method  static AlarmLevel CRITICAL()
 */
class AlarmLevel extends Enum
{
    const SAFE = 0;

    const INFO = 1;

    const WARNING = 2;

    const DANGER = 3;

    const CRITICAL = 4;
}
