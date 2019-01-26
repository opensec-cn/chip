<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:03
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Exception\ArgumentsFormatException;
use Chip\Message;
use PhpParser\Node;
use Chip\Code;
use PhpParser\Node\Expr\FuncCall;

class Assert_ extends BaseVisitor
{
    protected $checkNodeClass = [
        FuncCall::class
    ];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && $this->isMethod($node, ['assert']);
    }

    /**
     * @param \PhpParser\Node\Expr\FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process(Node $node)
    {
        if (empty($node->args)) {
            throw ArgumentsFormatException::create(Code::printNode($node));
        }

        $arg = $node->args[0];
        if (Code::hasVariable($arg) || Code::hasFunctionCall($arg)) {
            $this->message->critical($node, __CLASS__, 'assert第一个参数包含动态变量或函数，可能有远程代码执行的隐患');
        } else {
            $this->message->warning($node, __CLASS__, '请勿在生产环境下使用assert，可能导致任意代码执行漏洞');
        }
    }
}