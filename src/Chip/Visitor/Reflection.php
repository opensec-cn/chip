<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/27
 * Time: 21:33
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;

class Reflection extends BaseVisitor
{
    use TypeHelper;

    protected $checkNodeClass = [
        New_::class
    ];

    protected $reflectionClassName = [
        'ReflectionClass',
        'ReflectionZendExtension',
        'ReflectionExtension',
        'ReflectionFunction',
        'ReflectionFunctionAbstract',
        'ReflectionMethod',
        'ReflectionGenerator',
    ];

    /**
     * @param New_ $node
     */
    public function process($node)
    {
        if ($this->isName($node->class)) {
            $className = $node->class->toLowerString();
            if (in_array($className, array_map('strtolower', $this->reflectionClassName))) {
                $this->message->warning($node, __CLASS__, 'PHP反射类被创建，可能导致远程代码执行漏洞');
                return;
            }
        }
    }
}
