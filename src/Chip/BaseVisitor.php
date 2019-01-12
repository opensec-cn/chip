<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/8
 * Time: 0:56
 */

namespace Chip;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class BaseVisitor extends NodeVisitorAbstract
{
    /**
     * @type array $check_node_class
     */
    protected $check_node_class = [];

    public function checkNode(Node $node)
    {
        foreach ($this->check_node_class as $node_class) {
            if (is_a($node, $node_class)) {
                return true;
            }
        }
        return false;
    }

    public function enterNode(Node $node)
    {
        if($this->checkNode($node)) {
            $this->process($node);
        }
    }

    public function process(Node $node) {}
}