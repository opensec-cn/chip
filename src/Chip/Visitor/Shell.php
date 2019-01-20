<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/7
 * Time: 3:53
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Message;
use PhpParser\Node;
use Chip\Code;
use PhpParser\Node\Expr\ShellExec;

class Shell extends BaseVisitor
{
    protected $checkNodeClass = [
        ShellExec::class
    ];

    public function process(Node $node)
    {
        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            $this->message->critical($node, __CLASS__, '执行的命令中包含动态变量或函数，可能有远程命令执行风险');
        } else {
            $this->message->info($node, __CLASS__, '执行命令');
        }
    }
}