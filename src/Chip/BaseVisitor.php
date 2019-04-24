<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/8
 * Time: 0:56
 */

namespace Chip;

use Chip\Exception\NodeTypeException;
use Chip\Tracer\CallStack;
use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

abstract class BaseVisitor extends NodeVisitorAbstract implements VisitorInterface
{
    use TypeHelper;
    /**
     * @type array $checkNodeClass
     */
    protected $checkNodeClass = [];

    /**
     * @var Message $message
     */
    protected $message;

    /**
     * @var CallStack $stack
     */
    protected $stack;

    public function __construct(Message $message, CallStack $stack)
    {
        $this->message = $message;
        $this->stack = $stack;
    }

    public function checkNode(Node $node)
    {
        foreach ($this->checkNodeClass as $node_class) {
            if (is_a($node, $node_class)) {
                return true;
            }
        }
        return false;
    }

    public function enterNode(Node $node)
    {
        if (!$this->checkNode($node)) {
            return;
        }

        if ($this->beforeProcess($node)) {
            $this->process($node);
        }

        $this->afterProcess($node);
    }

    public function beforeProcess($node)
    {
        return true;
    }

    abstract public function process($node);

    public function afterProcess($node)
    {
    }
}
