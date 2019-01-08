<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 3:57
 */

namespace Chip\Traveller;

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
            echo "[danger]";
        }
    }
}