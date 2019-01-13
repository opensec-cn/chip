<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019/1/12
 * Time: 5:26 PM
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Exception\ArgumentsFormatException;
use Chip\Exception\RegexFormatException;
use Chip\Message;
use Chip\Structure\Regex;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class PregExec extends BaseVisitor
{
    protected $check_node_class = [FuncCall::class];

    protected $preg_functions = ['preg_replace', 'preg_filter'];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && in_array(strtolower($node->name), $this->preg_functions);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     * @throws RegexFormatException
     */
    public function process(Node $node)
    {
        if (empty($node->args)) {
            throw ArgumentsFormatException::create(Code::print_node($node));
        }
        $fname = strval($node->name);

        if (!($node->args[0]->value instanceof Node\Scalar\String_)) {
            Message::danger($node, "{$fname}第一个参数不是静态字符串，可能存在远程代码执行的隐患");
            return;
        }
        $regex = Regex::create($node->args[0]->value->value);
        if (strpos($regex->flags, 'e') !== false) {
            Message::danger($node, "{$fname}中正则表达式包含e模式，可能存在远程代码执行的隐患");
            return;
        }
    }
}