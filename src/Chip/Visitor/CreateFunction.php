<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/19
 * Time: 19:08
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Exception\ArgumentsFormatException;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class CreateFunction extends BaseVisitor
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
        return parent::checkNode($node) && $this->isMethod($node, ['create_function']);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process(Node $node)
    {
        if (count($node->args) < 2) {
            throw ArgumentsFormatException::create($node);
        }

        $args = $node->args[0]->value;
        $code = $node->args[1]->value;
        if (Code::hasVariable($args) || Code::hasVariable($args) || Code::hasVariable($code) || Code::hasFunctionCall($code)) {
            $this->message->critical($node, __class__, "create_function参数含有动态变量，可能有代码注入的隐患");
        } else {
            $this->message->warning($node, __class__, "使用create_function有代码执行的隐患，请使用闭包函数替代create_function");
        }
    }
}