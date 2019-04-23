<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/7
 * Time: 3:53
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Traits\Variable;
use PhpParser\Node;
use PhpParser\Node\Expr\ShellExec;

class Shell extends BaseVisitor
{
    use Variable;

    protected $checkNodeClass = [
        ShellExec::class
    ];

    public function process($node)
    {
        if ($this->hasDynamicExpr($node)) {
            $this->message->critical($node, __CLASS__, '执行的命令中包含动态变量或函数，可能有远程命令执行风险');
        } else {
            $this->message->info($node, __CLASS__, '执行命令');
        }
    }
}
