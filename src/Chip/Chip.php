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

    protected $travellers = [];

    function __construct()
    {

        $this->travellers = [];
        $this->bootstrapParser();
    }

    protected function bootstrapParser()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->traverser = new NodeTraverser();
    }

    public function traveller($travellers)
    {
        if(!is_array($travellers)) {
            $travellers = [$travellers];
        }

        $this->travellers = array_unique(array_merge($this->travellers, $travellers));
        return $this;
    }

    public function detect($code)
    {
        foreach ($this->travellers as $traveller_name) {
            $class = new $traveller_name;
            $this->traverser->addVisitor($class);
        }

        $stmts = $this->parser->parse($code);
        $this->traverser->traverse($stmts);
    }

    public function getAlerts()
    {
        return Visitor::getAlerts();
    }
}