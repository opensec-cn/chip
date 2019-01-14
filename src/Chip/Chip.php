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

    protected $visitors = [];

    function __construct()
    {

        $this->visitors = [];
        $this->bootstrapContainer();
        $this->bootstrapParser();
        $this->bootstrapStreamWrapper();
    }

    protected function bootstrapParser()
    {
        $lexer = new \PhpParser\Lexer(array(
            'usedAttributes' => array(
                'startLine', 'endLine', 'startFilePos', 'endFilePos'
            )
        ));

        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7, $lexer);
    }

    protected function bootstrapStreamWrapper()
    {
        stream_wrapper_register(MemoryStreamWrapper::WRAPPER_NAME, MemoryStreamWrapper::class);
    }

    protected function bootstrapContainer()
    {
        $this->container = new Container();
    }

    public function visitor($visitors)
    {
        if(!is_array($visitors)) {
            $visitors = [$visitors];
        }

        $this->visitors = array_unique(array_merge($this->visitors, $visitors));
        return $this;
    }

    /**
     * @param string $code
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function detect($code)
    {
        $traverser = new NodeTraverser();
        foreach ($this->visitors as $visitor_name) {
            $class = $this->container->get($visitor_name);
            $traverser->addVisitor($class);
        }

        $stmts = $this->parser->parse($code);
        $traverser->traverse($stmts);
    }

    /**
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getAlarms()
    {
        return $this->container->get('Chip\Message')->alarm;
    }
}