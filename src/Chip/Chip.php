<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/6
 * Time: 2:00
 */

namespace Chip;

use \PhpParser\ParserFactory;


class Chip
{
    function __construct()
    {

        $this->travellers = [];
        $this->bootstrapParser();
    }

    protected function bootstrapParser()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
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

    }
}