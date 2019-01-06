<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 3:57
 */

namespace Chip\Traveller;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use \PhpParser\Node\Expr\Eval_ as EvalNode;

class Eval_ extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if (!($node instanceof EvalNode)) {
            return;
        }


    }
}