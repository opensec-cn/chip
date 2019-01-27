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
use Chip\Structure\Regex;
use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class PregExec extends BaseVisitor
{
    use TypeHelper;

    protected $checkNodeClass = [FuncCall::class];

    protected $preg_functions = ['preg_replace', 'preg_filter'];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && $this->isMethod($node, $this->preg_functions);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     * @throws RegexFormatException
     */
    public function process(Node $node)
    {
        if (empty($node->args)) {
            throw ArgumentsFormatException::create(Code::printNode($node));
        }
        $fname = Code::getFunctionName($node);

        if (!$this->isString($node->args[0]->value)) {
            $this->message->danger($node, __CLASS__, "{$fname}第一个参数不是静态字符串，可能存在远程代码执行的隐患");
            return;
        }
        $regex = Regex::create($node->args[0]->value->value);
        if (strpos($regex->flags, 'e') !== false) {
            $this->message->danger($node, __CLASS__, "{$fname}中正则表达式包含e模式，可能存在远程代码执行的隐患");
            return;
        }
    }
}