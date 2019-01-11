<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:03
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Message;
use PhpParser\Node;
use Chip\Code;

class Assert_ extends BaseVisitor
{
    public function checkNode(Node $node)
    {
        return $node instanceof Node\Expr\FuncCall && strtolower($node->name) == 'assert';
    }

    /**
     * @param \PhpParser\Node\Expr\FuncCall $node
     */
    public function process(Node $node)
    {
        if (empty($node->args)) {
            return;
        }

        $node = $node->args[0];
        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            Message::critical('任意代码执行漏洞');
        } else {
            Message::warning('请勿在生产环境下使用assert，可能导致任意代码执行漏洞');
        }
    }
}