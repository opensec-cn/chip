<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 23:06
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Exception\ArgumentsFormatException;
use Chip\Exception\NodeTypeException;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class MbPregExec extends BaseVisitor
{
    use Variable, TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $whitelistFunctions = [
        'mb_ereg_replace',
        'mb_eregi_replace',
        'mb_regex_set_options'
    ];

    /**
     * @param  FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process($node)
    {
        $fname = $this->fname;
        $args_count = count($node->args);
        if (($fname == 'mb_ereg_replace' || $fname == 'mb_eregi_replace') && $args_count >= 4) {
            $option = $node->args[3]->value;
        } elseif ($fname == 'mb_regex_set_options' && $args_count >= 1) {
            $option = $node->args[0]->value;
        } elseif ($this->hasUnpackBefore($node->args)){
            $this->message->danger($node, __CLASS__, "{$fname}正则模式中使用变长参数，可能存在远程代码执行的隐患");
            return;
        } else {
            return;
        }

        if (!$this->isString($option)) {
            $this->message->danger($node, __CLASS__, "{$fname}正则模式不是静态字符串，可能存在远程代码执行的隐患");
            return;
        }

        if (strpos($option->value, 'e') !== false) {
            $this->message->danger($node, __CLASS__, "{$fname}使用正则模式“e”，可能存在远程代码执行的隐患");
            return;
        }
    }
}