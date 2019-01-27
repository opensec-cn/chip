<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 3:57
 */

namespace Chip\Visitor;

use Chip\Traits\Variable;
use PhpParser\Node;
use PhpParser\Node\Expr\Eval_ as EvalNode;
use Chip\BaseVisitor;

class Eval_ extends BaseVisitor
{
    use Variable;

    protected $checkNodeClass = [
        EvalNode::class
    ];

    /**
     * @param EvalNode $node
     */
    public function process(Node $node)
    {
        if ($this->hasDynamicExpr($node->expr)) {
            $this->message->critical($node, __CLASS__,'eval参数包含动态变量或函数，可能有远程代码执行的隐患');
        } else {
            $this->message->warning($node, __CLASS__, '使用eval执行PHP代码，可能存在安全风险');
        }
    }
}