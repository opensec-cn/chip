<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/8
 * Time: 1:02
 */

namespace Chip;


use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

class Code
{
    protected static $prettyPrinter = null;

    public static function printNode(Node $node)
    {
        if (is_null(self::$prettyPrinter)) {
            self::$prettyPrinter = new PrettyPrinter();
        }
        $code = self::$prettyPrinter->prettyPrint([$node]);
        return strip_whitespace($code);
    }
}