<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/8
 * Time: 0:56
 */

namespace Chip;

use PhpParser\NodeVisitorAbstract;

class Visitor extends NodeVisitorAbstract
{
    /**
     * @type array $alerts;
     */
    protected static $alerts = [];

    public static function getAlerts()
    {
        return self::$alerts;
    }
}