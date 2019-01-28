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
use Chip\Traits\FunctionInfo;
use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class MbPregExec extends BaseVisitor
{
    use TypeHelper, FunctionInfo;

    protected $checkNodeClass = [FuncCall::class];

    protected $preg_functions = ['mb_ereg_replace', 'mb_eregi_replace', 'mb_regex_set_options'];

    private $fname = '';

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        // $this->fname = $this->getFunctionName($node);
        return parent::checkNode($node) && $this->isMethod($node, $this->preg_functions);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process(Node $node)
    {
        try {
            $fname = $this->getFunctionName($node);
        } catch (NodeTypeException $e) {
            return;
        }

        $args_count = count($node->args);
        if (($fname == 'mb_ereg_replace' || $fname == 'mb_eregi_replace') && $args_count >= 4) {
            $option = $node->args[3]->value;
        } elseif ($fname == 'mb_regex_set_options' && $args_count >= 1) {
            $option = $node->args[0]->value;
        } else {
            return ;
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