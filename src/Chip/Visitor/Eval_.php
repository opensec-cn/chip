<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 3:57
 */

namespace Chip\Visitor;

use Chip\Code;
use Chip\Message;
use PhpParser\Node;
use PhpParser\Node\Expr\Eval_ as EvalNode;
use Chip\BaseVisitor;

class Eval_ extends BaseVisitor
{
    protected $check_node_class = [
        EvalNode::class
    ];

    public function process(Node $node)
    {
        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            Message::critical('任意代码执行漏洞');
        } else {
            Message::warning('使用eval执行PHP代码，可能存在安全风险');
        }
    }
}