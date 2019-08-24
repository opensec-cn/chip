<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/15
 * Time: 23:50
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use PhpParser\Node;

class DynamicCall extends BaseVisitor
{
    use Variable, TypeHelper;

    protected $checkNodeClass = [
        Node\Expr\FuncCall::class
    ];

    /**
     * @param Node\Expr\FuncCall $node
     */
    public function process($node)
    {
        if ($this->hasDynamicExpr($node->name)) {
            $this->storage->danger($node, __CLASS__, '动态调用函数，可能存在远程代码执行的隐患');
            return;
        }

        if (!$this->isName($node->name)) {
            $this->storage->warning($node, __CLASS__, '不规则的函数调用方式，可能存在安全风险');
            return;
        }
    }
}
