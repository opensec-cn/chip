<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/26
 * Time: 0:49
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;

class DynamicStaticMethod extends BaseVisitor
{
    protected $checkNodeClass = [
        StaticCall::class
    ];

    /**
     * @param StaticCall $node
     */
    public function process(Node $node)
    {
        $class = $node->class;
        $name = $node->name;

        if (Code::hasVariable($class) || Code::hasFunctionCall($class)) {
            $this->message->warning($node, __CLASS__, '以动态类形式调用静态方法，可能存在远程代码执行的隐患');
            return;
        }

        if (Code::hasVariable($name) || Code::hasFunctionCall($name)) {
            $this->message->danger($node, __CLASS__, '动态调用方法，可能存在远程代码执行的隐患');
            return;
        }

        if (!($class instanceof Node\Name) || !($name instanceof Node\Identifier)) {
            $this->message->warning($node, __CLASS__, '不规范的静态方法调用，可能存在远程代码执行的隐患');
            return;
        }
    }
}