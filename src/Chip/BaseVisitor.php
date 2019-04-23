<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/8
 * Time: 0:56
 */

namespace Chip;

use Chip\Exception\NodeTypeException;
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

    public function __construct(Message $message)
    {
        $this->message = $message;
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

    /**
     * @param  Node  $node
     * @param  array $required
     * @return bool
     */
    protected function isMethod(Node $node, array $required)
    {
        try {
            if ($node instanceof Node\Expr\FuncCall) {
                $fname = $this->getFunctionName($node);
            } elseif ($node instanceof Node\Expr\MethodCall || $node instanceof Node\Expr\StaticCall) {
                $fname = $this->getMethodName($node);
            } else {
                return false;
            }
        } catch (NodeTypeException $e) {
            return false;
        }

        return in_array($fname, $required);
    }
}
