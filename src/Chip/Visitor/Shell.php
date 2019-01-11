<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/7
 * Time: 3:53
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use PhpParser\Node;
use Chip\Code;
use Chip\Alert;

class Shell extends BaseVisitor
{
    public function enterNode(Node $node)
    {
        if (!($node instanceof Node\Expr\ShellExec)) {
            return;
        }

        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            self::$alerts[] = Alert::critical('任意命令执行漏洞');
        }
    }
}