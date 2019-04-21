<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/12
 * Time: 2:03
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use function Chip\dump_node;
use Chip\Exception\ArgumentsFormatException;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node\Expr\FuncCall;

class Assert_ extends BaseVisitor
{
    use Variable, TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $whitelistFunctions = [
        'assert'
    ];

    /**
     * @param  \PhpParser\Node\Expr\FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process($node)
    {
        if (empty($node->args)) {
            return;
        }

        $arg = $node->args[0];
        if ($this->hasDynamicExpr($arg->value)) {
            $this->message->critical($node, __CLASS__, 'assert第一个参数包含动态变量或函数，可能有远程代码执行的隐患');
        } else {
            $this->message->warning($node, __CLASS__, '请勿在生产环境下使用assert，可能导致任意代码执行漏洞');
        }
    }
}