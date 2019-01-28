<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/19
 * Time: 19:08
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use function Chip\dump_node;
use Chip\Exception\ArgumentsFormatException;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node\Expr\FuncCall;

class CreateFunction extends BaseVisitor
{
    use Variable, TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $whitelistFunctions = [
        'create_function'
    ];

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process($node)
    {
        if (count($node->args) < 2) {
            throw ArgumentsFormatException::create(dump_node($node));
        }

        $args = $node->args[0]->value;
        $code = $node->args[1]->value;
        if ($this->hasDynamicExpr($args) || $this->hasDynamicExpr($code)) {
            $this->message->critical($node, __class__, "create_function参数含有动态变量，可能有代码注入的隐患");
        } else {
            $this->message->warning($node, __class__, "使用create_function有代码执行的隐患，请使用闭包函数替代create_function");
        }
    }
}