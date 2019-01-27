<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/22
 * Time: 2:30
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;

class StaticCallback extends BaseVisitor
{
    use TypeHelper;

    protected $checkNodeClass = [
        StaticCall::class
    ];

    protected $sensitiveMethodName = [
        'phar::webphar' => [4],
        'closure::fromcallable' => [0]
    ];

    public function checkNode(Node $node)
    {
        if (!parent::checkNode($node)) {
            return false;
        }

        /**
         * @var StaticCall $node
         */
        if ($this->isName($node->class) && $this->isIdentifier($node->name)) {
            $class = $node->class->toLowerString();
            $fname = $node->name->toLowerString();
            return in_array("{$class}::{$fname}", array_keys($this->sensitiveMethodName));
        }

        return false;
    }

    /**
     * @param StaticCall $node
     */
    public function process(Node $node)
    {
        $fname = "{$node->class->toLowerString()}::{$node->name->toLowerString()}";
        foreach($this->sensitiveMethodName[$fname] as $pos) {
            if ($pos >= 0 && array_key_exists($pos, $node->args)) {
                $arg = $node->args[$pos];
            } elseif ($pos < 0 && array_key_exists(count($node->args) + $pos, $node->args)) {
                $arg = $node->args[ count($node->args) + $pos ];
            } else {
                continue ;
            }

            if (Code::hasVariable($arg->value) || Code::hasFunctionCall($arg->value)) {
                $this->message->danger($node, __CLASS__, "{$fname}方法第{$pos}个参数包含动态变量或函数，可能有远程代码执行的隐患");
            } elseif (!($arg->value instanceof Node\Expr\Closure)) {
                $this->message->warning($node, __CLASS__, "{$fname}方法第{$pos}个参数，请使用闭包函数");
            }
        }
    }
}