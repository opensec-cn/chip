<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/28
 * Time: 4:03
 */

namespace Chip\Traits;


use PhpParser\Node;

trait Variable
{
    protected function traverseNode(Node $node, Callable $callback)
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

    public function hasVariable(Node $node)
    {
        $hasVariable = $this->traverseNode(
            $node, function ($cur_node) {
                if ($cur_node instanceof Node\Expr\Variable || $cur_node instanceof Node\Expr\PropertyFetch || $cur_node instanceof Node\Expr\ConstFetch || $cur_node instanceof Node\Expr\ClassConstFetch) {
                    return true;
                }

                return null;
            }
        );

        return boolval($hasVariable);
    }

    public function hasFunctionCall(Node $node)
    {
        $hasFunctionCall = $this->traverseNode(
            $node, function ($cur_node) {
                if ($cur_node instanceof Node\Expr\MethodCall || $cur_node instanceof Node\Expr\FuncCall || $cur_node instanceof Node\Expr\New_ || $cur_node instanceof Node\Expr\StaticCall) {
                    return true;
                }

                return null;
            }
        );

        return boolval($hasFunctionCall);
    }

    public function hasDynamicExpr(Node $node)
    {
        return $this->hasVariable($node) || $this->hasFunctionCall($node);
    }
}