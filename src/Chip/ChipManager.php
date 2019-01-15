<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-15
 * Time: 18:10
 */

namespace Chip;


use Chip\Exception\FormatException;
use DI\DependencyException;
use DI\NotFoundException;

class ChipManager
{
    protected $visitor_classes = [];

    public function addVisitor(string $visitor)
    {
        if(!in_array($visitor, $this->visitor_classes)) {
            $this->visitor_classes[] = $visitor;
        }
    }

    /**
     * @param string $code
     * @return array
     * @throws FormatException
     */
    public function detect(string $code)
    {
        $chip = new Chip($this->visitor_classes);
        return $chip->feed($code)->alarm();
    }
}