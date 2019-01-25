<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/26
 * Time: 0:26
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use PhpParser\Node;
use Chip\Code;

class DynamicMethod extends BaseVisitor
{
    protected $checkNodeClass = [
        Node\Expr\MethodCall::class
    ];

    /**
     * @param Node\Expr\MethodCall $node
     */
    public function process(Node $node)
    {
        if (Code::hasVariable($node->name) || Code::hasFunctionCall($node->name)) {
            $this->message->danger($node, __CLASS__, '动态调用方法，可能存在远程代码执行的隐患');
            return;
        }

        if (!($node->name instanceof Node\Identifier)) {
            $this->message->warning($node, __CLASS__, '不规则的方法调用，可能存在安全风险');
            return;
        }
    }
}