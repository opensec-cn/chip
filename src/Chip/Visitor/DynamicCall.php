<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/15
 * Time: 23:50
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use PhpParser\Node;

class DynamicCall extends BaseVisitor
{
    protected $check_node_class = [
        Node\Expr\FuncCall::class
    ];

    /**
     * @param Node\Expr\FuncCall $node
     */
    public function process(Node $node)
    {
        if (Code::hasVariable($node->name) || Code::hasFunctionCall($node->name)) {
            $this->message->danger($node, __CLASS__, '动态调用函数，可能存在远程代码执行的隐患');
            return;
        }

        if (!($node->name instanceof Node\Name)) {
            $this->message->warning($node, __CLASS__, '不规则的函数调用方式，可能存在安全风险');
            return;
        }
    }
}