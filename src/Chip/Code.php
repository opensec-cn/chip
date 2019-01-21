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

    static public function traverseNode(Node $node, Callable $callback)
    {
        $queue = new \SplQueue();
        $visites = [];
        $queue->enqueue($node);
        while (!$queue->isEmpty()) {
            $cur_node = $queue->dequeue();
            if ($cur_node instanceof Node) {
                $ret = call_user_func($callback, $cur_node);
                if ($ret !== null) {
                    return $ret;
                }
            }
            array_push($visites, $cur_node);
            if (is_array($cur_node)) {
                foreach ($cur_node as $subNode) {
                    if (!in_array($subNode, $visites, true)) {
                        $queue->enqueue($subNode);
                    }
                }
            } elseif ($cur_node instanceof Node) {
                foreach ($cur_node->getSubNodeNames() as $name) {
                    $subNode = $cur_node->$name;
                    if (!in_array($subNode, $visites, true)) {
                        $queue->enqueue($subNode);
                    }
                }
            }
        }
        return null;
    }

    static public function hasVariable(Node $node)
    {
        $hasVariable = static::traverseNode($node, function ($cur_node) {
            if ($cur_node instanceof Node\Expr\Variable || $cur_node instanceof Node\Identifier || $cur_node instanceof Node\Expr\ConstFetch || $cur_node instanceof Node\Expr\ClassConstFetch) {
                return true;
            }

            return null;
        });

        return boolval($hasVariable);
    }

    static public function hasFunctionCall(Node $node)
    {
        $hasFunctionCall = static::traverseNode($node, function ($cur_node) {
            if ($cur_node instanceof Node\Expr\MethodCall || $cur_node instanceof Node\Expr\FuncCall || $cur_node instanceof Node\Expr\New_ || $cur_node instanceof Node\Expr\StaticCall) {
                return true;
            }

            return null;
        });

        return boolval($hasFunctionCall);
    }

    public static function printNode(Node $node)
    {
        if (is_null(self::$prettyPrinter)) {
            self::$prettyPrinter = new PrettyPrinter();
        }
        $code = self::$prettyPrinter->prettyPrint([$node]);
        return strip_whitespace($code);
    }

    public static function isQualifyCall(Node $node)
    {
        if ($node instanceof Node\Expr\FuncCall) {
            return $node->name instanceof Node\Name || $node->name instanceof Node\Scalar\String_;
        } elseif ($node instanceof Node\Expr\MethodCall) {
            return $node->name instanceof Node\Identifier;
        } elseif ($node instanceof Node\Expr\StaticCall) {
            return $node->class instanceof Node\Name && $node->name instanceof Node\Identifier;
        } else {
            return false;
        }
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