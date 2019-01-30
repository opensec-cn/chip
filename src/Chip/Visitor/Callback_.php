<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/18
 * Time: 23:46
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Exception\NodeTypeException;
use Chip\Message;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class Callback_ extends BaseVisitor
{
    use Variable, TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $functionWithCallback = [];

    function __construct(Message $message)
    {
        parent::__construct($message);
        $this->functionWithCallback = array_reduce(
            FUNCTION_WITH_CALLABLE, function ($carry, $item) {
                if (array_key_exists($item['function'], $carry)) {
                    $carry[$item['function']][] = $item['pos'];
                } else {
                    $carry[$item['function']] = [$item['pos']];
                }

                return $carry;
            }, []
        );
    }

    function getWhitelistFunctions()
    {
        return array_keys($this->functionWithCallback);
    }

    /**
     * @param FuncCall $node
     */
    public function process($node)
    {
        $fname = $this->fname;
        foreach($this->functionWithCallback[$fname] as $pos) {
            if ($pos >= 0 && array_key_exists($pos, $node->args)) {
                $arg = $node->args[$pos];
            } elseif ($pos < 0 && array_key_exists(count($node->args) + $pos, $node->args)) {
                $arg = $node->args[ count($node->args) + $pos ];
            } else {
                continue ;
            }

            if ($this->hasDynamicExpr($arg->value)) {
                $this->message->danger($node, __CLASS__, "{$fname}第{$pos}个参数包含动态变量或函数，可能有远程代码执行的隐患");
            } elseif (!$this->isClosure($arg->value)) {
                $this->message->warning($node, __CLASS__, "{$fname}第{$pos}个参数，请使用闭包函数");
            }
        }
    }
}