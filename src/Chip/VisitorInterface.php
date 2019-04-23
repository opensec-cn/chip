<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-15
 * Time: 21:26
 */

namespace Chip;

use PhpParser\Node;
use PhpParser\NodeVisitor;

interface VisitorInterface extends NodeVisitor
{
    public function checkNode(Node $node);

    public function process($node);
}
