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

    function __construct(array $visitors)
    {

        $this->visitors = [];
        $this->bootstrapContainer();
        $this->bootstrapParser();
        $this->bootstrapStreamWrapper();
        $this->bootstrapVisitor($visitors);
    }

    protected function bootstrapParser()
    {
        $lexer = new \PhpParser\Lexer(array(
            'usedAttributes' => array(
                'startLine', 'endLine', 'startFilePos', 'endFilePos'
            )
        ));

        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7, $lexer);
        $this->traverser = new NodeTraverser();
    }

    protected function bootstrapStreamWrapper()
    {
        stream_wrapper_register(MemoryStreamWrapper::WRAPPER_NAME, MemoryStreamWrapper::class);
    }

    protected function bootstrapContainer()
    {
        $this->container = new Container();
    }

    /**
     * @param array $visitors
     */
    protected function bootstrapVisitor(array $visitors)
    {
        try {
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
     * @param $code
     * @return $this
     * @throws Exception\FormatException
     */
    public function feed($code)
    {
        $stmts = $this->parser->parse($code);
        $this->traverser->traverse($stmts);

        return $this;
    }

    /**
     * 获取所有告警结果
     *
     * @return array
     */
    public function alarm()
    {
        try {
            $message = $this->container->get('Chip\Message');
            return $message;
        } catch (\DI\DependencyException | \DI\NotFoundException $e) {
            return [];
        }
    }
}