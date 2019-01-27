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

    /**
     * @param Node\Expr\FuncCall $node
     * @return Node|string
     */
    public static function getFunctionName(Node\Expr\FuncCall $node)
    {
        if ($node->name instanceof Node\Name) {
            return $node->name->toLowerString();
        } elseif ($node->name instanceof Node\Scalar\String_) {
            return strtolower($node->name->value);
        } else {
            return $node;
        }
    }

    /**
     * @param Node\Expr\MethodCall | Node\Expr\StaticCall $node
     * @return Node|string
     */
    public static function getMethodName(Node $node)
    {
        if ($node->name instanceof Node\Identifier) {
            return $node->name->toLowerString();
        } else {
            return $node;
        }
    }
}