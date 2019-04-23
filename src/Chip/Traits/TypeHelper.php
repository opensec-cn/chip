<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/28
 * Time: 3:12
 */

namespace Chip\Traits;

use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node;
use Chip\Exception\NodeTypeException;

trait TypeHelper
{
    public function isString(Node $node)
    {
        return $node instanceof String_ || $node instanceof Node\Scalar\EncapsedStringPart;
    }

    public function isQualify(Node $node)
    {
        return $this->isName($node) || $this->isIdentifier($node);
    }

    public function isName(Node $node)
    {
        return $node instanceof Name;
    }

    public function isIdentifier(Node $node)
    {
        return $node instanceof Identifier;
    }

    public function isClosure(Node $node)
    {
        return $node instanceof Node\Expr\Closure;
    }

    public function isNumber(Node $node)
    {
        return $node instanceof Node\Scalar\LNumber || $node instanceof Node\Scalar\DNumber;
    }

    public function isBitwise(Node $node)
    {
        return $node instanceof Node\Expr\BinaryOp\BitwiseAnd
            || $node instanceof Node\Expr\BinaryOp\BitwiseOr
            || $node instanceof Node\Expr\BinaryOp\BitwiseXor;
    }

    public function isConstant(Node $node)
    {
        return $node instanceof Node\Expr\ConstFetch;
    }

    public function isMixConstant(Node $node)
    {
        if ($this->isBitwise($node)) {
            $queue = new \SplQueue();
            $queue->enqueue($node);
            while (!$queue->isEmpty()) {
                $currentNode = $queue->dequeue();

                if ($this->isBitwise($currentNode)) {
                    $queue->enqueue($currentNode->left);
                    $queue->enqueue($currentNode->right);
                } else {
                    if (!$this->isConstant($currentNode)) {
                        return false;
                    }
                }
            }
            return true;
        }

        return false;
    }

    public function isVariable(Node $node)
    {
        return $node instanceof Node\Expr\Variable;
    }

    public function isArray(Node $node)
    {
        return $node instanceof Node\Expr\Array_;
    }

    public function isSafeCallback(Node\Arg $arg)
    {
        if (!$this->isString($arg->value)) {
            return false;
        }

        $function = strtolower($arg->value->value);
        if (preg_match('/^\\\\?[a-z0-9_]+$/is', $function) &&
            !in_array(ltrim($function, '\\'), DANGER_FUNCTION, true)) {
            return true;
        }

        return false;
    }

    /**
     * @param  Node\Expr\FuncCall $node
     * @return string
     * @throws NodeTypeException
     */
    public function getFunctionName(Node\Expr\FuncCall $node)
    {
        if ($this->isName($node->name)) {
            return $node->name->toLowerString();
        } elseif ($this->isString($node->name)) {
            /**
             * @var \PhpParser\Node\Scalar\String_ $node->name
             */
            return strtolower($node->name->value);
        } else {
            throw new NodeTypeException();
        }
    }

    /**
     * @param  Node\Expr\MethodCall | Node\Expr\StaticCall $node
     * @return Node|string
     * @throws NodeTypeException
     */
    public function getMethodName(Node $node)
    {
        if ($this->isIdentifier($node->name)) {
            return $node->name->toLowerString();
        } else {
            throw new NodeTypeException();
        }
    }
}
