<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-15
 * Time: 21:15
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use PhpParser\Node;
use Chip\Code;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\String_;

class Include_ extends BaseVisitor
{
    protected $check_node_class = [
        Node\Expr\Include_::class
    ];

    protected $extension_whitelist = ['php', 'inc'];

    /**
     * @param Node\Expr\Include_ $node
     */
    public function process(Node $node)
    {
        $last_part = $node->expr;
        if ($node->expr instanceof Node\Scalar\Encapsed) {
            $last_part = end($node->expr->parts);
        } elseif ($node->expr instanceof Concat) {
            $last_part = $this->getRecursivePart($node->expr);
        }

        if ($last_part instanceof String_) {
            if (!$this->isSafeExtension($last_part)) {
                $this->message->danger($node, '文件包含了非PHP文件，可能有远程代码执行的隐患');
            }
            return;
        }

        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            $this->message->danger($node, '文件包含操作存在动态变量或函数，可能有远程代码执行的隐患');
            return;
        }
    }

    protected function isSafeExtension(String_ $node)
    {
        $filename = $node->value;

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, $this->extension_whitelist);
    }

    protected function getRecursivePart(Concat $node)
    {
        while ($node->right instanceof Concat) {
            $node = $node->right;
        }

        return $node->right;
    }
}