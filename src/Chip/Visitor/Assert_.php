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

        $arg = $node->args[0];
        if (Code::hasVariable($arg) || Code::hasFunctionCall($arg)) {
            $this->message->critical($node,'assert第一个参数包含动态变量或函数，可能有远程代码执行的隐患');
        } else {
            $this->message->warning($node,'请勿在生产环境下使用assert，可能导致任意代码执行漏洞');
        }
    }
}