<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/28
 * Time: 2:30
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Traits\Variable;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;

class DynamicNew extends BaseVisitor
{
    use Variable;

    protected $checkNodeClass = [
        New_::class
    ];

    /**
     * @param New_ $node
     */
    public function process($node)
    {
        if ($this->hasVariable($node->class)) {
            $this->storage->warning($node, __CLASS__, '动态创建类对象，可能存在远程代码执行的隐患');
            return;
        }
    }
}
