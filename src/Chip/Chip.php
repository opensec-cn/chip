<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 2:00
 */

namespace Chip;


use \PhpParser\ParserFactory;
use \PhpParser\NodeTraverser;

class Chip
{
    /**
     * @var \PhpParser\Parser $parser;
     */
    protected $parser = null;

    /**
     * @var NodeTraverser $traverser
     */
    protected $traverser = null;

    protected $visitors = [];

    function __construct()
    {

        $this->visitors = [];
        $this->bootstrapParser();
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

    public function visitor($visitors)
    {
        if(!is_array($visitors)) {
            $visitors = [$visitors];
        }

        $this->visitors = array_unique(array_merge($this->visitors, $visitors));
        return $this;
    }

    public function detect($code)
    {
        foreach ($this->visitors as $visitor_name) {
            $class = new $visitor_name;
            $this->traverser->addVisitor($class);
        }

        $stmts = $this->parser->parse($code);
        $this->traverser->traverse($stmts);
    }

    public function getAlarms()
    {
        return Message::$alarm;
    }
}