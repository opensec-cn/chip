<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/18
 * Time: 2:20
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Code;
use Chip\Exception\ArgumentsFormatException;
use Chip\Exception\FormatException;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class ShellFunction extends BaseVisitor
{
    protected $check_node_class = [
        FuncCall::class
    ];

    protected $exec_functions = [
        'system',
        'shell_exec',
        'exec',
        'passthru',
        'popen',
        'proc_open'
    ];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode(Node $node)
    {
        return parent::checkNode($node) && $this->isMethod($node, $this->exec_functions);
    }

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process(Node $node)
    {
        if (empty($node->args)) {
            throw ArgumentsFormatException::create(Code::printNode($node));
        }

        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            $this->message->critical($node, __CLASS__, '执行的命令中包含动态变量或函数，可能有远程命令执行风险');
        } else {
            $this->message->info($node, __CLASS__, '执行命令');
        }

    }
}