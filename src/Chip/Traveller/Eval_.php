<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 3:57
 */

namespace Chip\Traveller;

use Chip\Alert;
use Chip\Code;
use PhpParser\Node;
use PhpParser\Node\Expr\Eval_ as EvalNode;
use Chip\Visitor;

class Eval_ extends Visitor
{
    public function enterNode(Node $node)
    {
        if (!($node instanceof EvalNode)) {
            return;
        }

        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            self::$alerts[] = Alert::critical('任意代码执行漏洞');
        } else {
            self::$alerts[] = Alert::warning('使用eval执行PHP代码，可能存在安全风险');
        }
    }
}