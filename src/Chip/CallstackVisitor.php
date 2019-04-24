<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-04-25
 * Time: 01:51
 */

namespace Chip;

use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Chip\Tracer\CallStack;

class CallstackVisitor extends NodeVisitorAbstract
{
    use TypeHelper;

    protected $stack = null;

    public function __construct(CallStack $stack)
    {
        $this->stack = $stack;
    }

    public function enterNode(Node $node)
    {
        if ($this->isFunctionEnter($node)) {
            $this->stack->push($node);
        }
    }

    public function leaveNode(Node $node)
    {
        if (!$this->stack->isEmpty() && $node === $this->stack->top()) {
            $this->stack->pop();
        }
    }
}
