<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/7
 * Time: 3:53
 */

namespace Chip\Traveller;

use Chip\Visitor;
use PhpParser\Node;
use Chip\Code;
use Chip\Alert;

class Shell extends Visitor
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