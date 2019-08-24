<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 2:00
 */

namespace Chip;

use DI\Container;
use \PhpParser\ParserFactory;
use \PhpParser\NodeTraverser;

class Chip
{
    /**
     * @var \PhpParser\Parser $parser;
     */
    protected $parser = null;

    /**
     * @var Container $container
     */
    protected $container;

    /**
     * @var NodeTraverser $traverser
     */
    protected $traverser;

    /**
     * @var Storage $storage
     */
    protected $storage;

    public function __construct(array $visitors)
    {
        $this->bootstrapContainer();
        $this->bootstrapParser();
        $this->bootstrapMessage();

        array_unshift($visitors, \PhpParser\NodeVisitor\NameResolver::class);
        $this->bootstrapVisitor($visitors);
    }

    protected function bootstrapParser()
    {
        $lexer = new \PhpParser\Lexer(
            [
            'usedAttributes' => [
                'startLine',
                'endLine',
                'startFilePos',
                'endFilePos',
                ],
            ]
        );

        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7, $lexer);
        $this->traverser = new NodeTraverser();
    }

    protected function bootstrapContainer()
    {
        $this->container = new Container();
    }

    protected function bootstrapMessage()
    {
        try {
            $this->storage = $this->container->get(Storage::class);
        } catch (\DI\DependencyException | \DI\NotFoundException $e) {
            // something wrong?
        }
    }

    /**
     * @param array $visitors
     */
    protected function bootstrapVisitor(array $visitors)
    {
        try {
            $this->traverser->addVisitor($this->container->get(CallstackVisitor::class));
            foreach ($visitors as $visitor_name) {
                $class = $this->container->get($visitor_name);
                $this->traverser->addVisitor($class);
            }
        } catch (\DI\DependencyException | \DI\NotFoundException $e) {
            // something wrong?
        }
    }

    /**
     * 对代码进行扫描测试
     *
     * @param  string $code
     * @return $this
     */
    public function feed($code)
    {
        try {
            $stmts = $this->parser->parse($code);
            $this->traverser->traverse($stmts);
        } catch (\PhpParser\Error $e) {
            $this->storage->putMessage(
                AlarmLevel::WARNING(),
                'InvalidPhpFile',
                'PHP脚本格式错误，可能是Webshell'
            );
        }

        return $this;
    }

    /**
     * 获取所有告警结果
     *
     * @return Alarm[]
     */
    public function alarms()
    {
        return $this->storage->getArrayCopy();
    }
}
