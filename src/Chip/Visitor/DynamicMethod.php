<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/26
 * Time: 0:26
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use PhpParser\Node;

class DynamicMethod extends BaseVisitor
{
    use Variable, TypeHelper;

    protected $checkNodeClass = [
        Node\Expr\MethodCall::class
    ];

    /**
     * @param Node\Expr\MethodCall $node
     */
    public function process($node)
    {
        if ($this->hasDynamicExpr($node->name)) {
            $this->storage->danger($node, __CLASS__, '动态调用方法，可能存在远程代码执行的隐患');
            return;
        }

        if (!$this->isIdentifier($node->name)) {
            $this->storage->warning($node, __CLASS__, '不规则的方法调用，可能存在安全风险');
            return;
        }
    }
}
