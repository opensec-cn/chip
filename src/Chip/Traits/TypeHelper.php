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

trait TypeHelper
{
    public function isString(Node $node)
    {
        return $node instanceof String_ || $node instanceof Node\Scalar\EncapsedStringPart;
    }

    public function isQualify(Node $node)
    {
        return $this->isName($node) || $this->isQualify($node);
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
}