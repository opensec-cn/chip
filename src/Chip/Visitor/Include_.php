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
use PhpParser\Node\Scalar\EncapsedStringPart;
use PhpParser\Node\Scalar\Encapsed;

class Include_ extends BaseVisitor
{
    protected $checkNodeClass = [
        Node\Expr\Include_::class
    ];

    protected $extension_whitelist = ['php', 'inc'];

    /**
     * @param Node\Expr\Include_ $node
     */
    public function process(Node $node)
    {
        $last_part = $this->getRecursivePart($node->expr);

        if ($last_part instanceof String_ || $last_part instanceof EncapsedStringPart) {
            if (!$this->isSafeExtension($last_part)) {
                $this->message->danger($node, __CLASS__, '文件包含了非PHP文件，可能有远程代码执行的隐患');
            }
            return;
        }

        if (Code::hasVariable($node) || Code::hasFunctionCall($node)) {
            $this->message->danger($node, __CLASS__, '文件包含操作存在动态变量或函数，可能有远程代码执行的隐患');
            return;
        }
    }

    /**
     * @param String_|EncapsedStringPart $node
     * @return bool
     */
    protected function isSafeExtension($node)
    {
        $filename = $node->value;

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, $this->extension_whitelist);
    }

    protected function getRecursivePart($node)
    {
        while (true) {
            if ($node instanceof Concat) {
                $node = $node->right;
            } elseif ($node instanceof Encapsed) {
                $node = end($node->parts);
            } else {
                break;
            }
        }

        return $node;
    }
}