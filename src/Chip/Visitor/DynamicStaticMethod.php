<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/26
 * Time: 0:49
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;

class DynamicStaticMethod extends BaseVisitor
{
    use Variable, TypeHelper;

    protected $checkNodeClass = [
        StaticCall::class
    ];

    /**
     * @param StaticCall $node
     */
    public function process($node)
    {
        $class = $node->class;
        $name = $node->name;

        if ($this->hasDynamicExpr($class)) {
            $this->message->warning($node, __CLASS__, '以动态类形式调用静态方法，可能存在远程代码执行的隐患');
            return;
        }

        if ($this->hasVariable($name)) {
            $this->message->danger($node, __CLASS__, '动态调用方法，可能存在远程代码执行的隐患');
            return;
        }

        if (!$this->isName($class) || !$this->isIdentifier($name)) {
            $this->message->warning($node, __CLASS__, '不规范的静态方法调用，可能存在远程代码执行的隐患');
            return;
        }
    }
}