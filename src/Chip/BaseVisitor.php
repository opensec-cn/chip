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

abstract class BaseVisitor extends NodeVisitorAbstract implements VisitorInterface
{
    /**
     * @type array $check_node_class
     */
    protected $check_node_class = [];

    /**
     * @var Message $message
     */
    protected $message;

    function __construct(Message $message)
    {
        $this->message = $message;
    }

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

    abstract public function process(Node $node);
}