<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 23:06
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Exception\ArgumentsFormatException;
use Chip\Message;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class MbPregExec extends BaseVisitor
{
    protected $check_node_class = [FuncCall::class];

    protected $preg_functions = ['mb_ereg_replace', 'mb_eregi_replace', 'mb_regex_set_options'];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && is_string($fname = Code::getFunctionName($node)) && in_array($fname, $this->preg_functions);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process(Node $node)
    {
        $fname = Code::getFunctionName($node);
        $args_count = count($node->args);
        if (($fname == 'mb_ereg_replace' || $fname == 'mb_eregi_replace') && $args_count >= 4) {
            $option = $node->args[3]->value;
        } elseif ($fname == 'mb_regex_set_options' && $args_count >= 1) {
            $option = $node->args[0]->value;
        } else {
            return ;
        }

        if (!($option instanceof Node\Scalar\String_)) {
            $this->message->danger($node, __CLASS__, "{$fname}正则模式不是静态字符串，可能存在远程代码执行的隐患");
            return;
        }

        if (strpos($option->value, 'e') !== false) {
            $this->message->danger($node, __CLASS__, "{$fname}使用正则模式“e”，可能存在远程代码执行的隐患");
            return;
        }
    }
}