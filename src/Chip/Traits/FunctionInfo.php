<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-28
 * Time: 14:35
 */

namespace Chip\Traits;


use Chip\Exception\NodeTypeException;
use PhpParser\Node;

trait FunctionInfo
{
    use TypeHelper;

    /**
     * @param Node\Expr\FuncCall $node
     * @return string
     * @throws NodeTypeException
     */
    public function getFunctionName(Node\Expr\FuncCall $node)
    {
        if ($this->isName($node->name)) {
            return $node->name->toLowerString();
        } elseif ($this->isString($node->name)) {
            return strtolower($node->name->value);
        } else {
            throw new NodeTypeException();
        }
    }

    /**
     * @param Node\Expr\MethodCall | Node\Expr\StaticCall $node
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