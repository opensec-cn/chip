<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/18
 * Time: 23:46
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Message;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class Callback_ extends BaseVisitor
{
    protected $check_node_class = [
        FuncCall::class
    ];

    protected $function_with_callback = [];

    function __construct(Message $message)
    {
        parent::__construct($message);
        $this->function_with_callback = FUNCTION_WITH_CALLABLE;
    }

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && $this->isMethod($node, array_keys($this->function_with_callback));
    }

    /**
     * @param FuncCall $node
     */
    public function process(Node $node)
    {
        $fname = Code::getFunctionName($node);

        $config = $this->function_with_callback[$fname];
        if ($config['pos'] >= 0 && array_key_exists($config['pos'], $node->args)) {
            $arg = $node->args[$config['pos']];
        } elseif ($config['pos'] < 0 && array_key_exists(count($node->args) + $config['pos'], $node->args)) {
            $arg = $node->args[ count($node->args) + $config['pos'] ];
        } else {
            return ;
        }

        if (Code::hasVariable($arg->value) || Code::hasFunctionCall($arg->value)) {
            $this->message->danger($node, __CLASS__, "{$fname}第{$config['pos']}个参数包含动态变量或函数，可能有远程代码执行的隐患");
        } elseif (!($arg->value instanceof Node\Expr\Closure)) {
            $this->message->warning($node, __CLASS__, "{$fname}第{$config['pos']}个参数，请使用闭包函数");
        }
    }
}