<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/28
 * Time: 3:48
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use Chip\Traits\TypeHelper;
use PhpParser\Node;

class Extends_ extends BaseVisitor
{
    use TypeHelper;

    protected $checkNodeClass = [
        Node\Stmt\Class_::class
    ];

    protected $dangerClassName = [
        'ReflectionClass',
        'ReflectionZendExtension',
        'ReflectionExtension',
        'ReflectionFunction',
        'ReflectionFunctionAbstract',
        'ReflectionMethod',
        'ReflectionGenerator'
    ];

    /**
     * @param Node\Stmt\Class_ $node
     */
    public function process($node)
    {
        if ($this->isName($node->extends)) {
            $className = $node->extends->toLowerString();

            if (in_array($className, array_map('strtolower', $this->dangerClassName))) {
                $this->message->danger($node, __CLASS__, '代码继承了不安全的类');
                return;
            }
        }
    }
}