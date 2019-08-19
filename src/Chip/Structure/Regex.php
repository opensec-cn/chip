<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 2:25
 */

namespace Chip\Structure;

use Chip\Exception\RegexFormatException;

class Regex
{
    /**
     * @var string $regex
     */
    public $regex;

    /**
     * @var string $delimiter
     * one char string
     */
    public $delimiter;

    /**
     * @var string flags
     */
    public $flags;

    public function __construct($regex, $delimiter, $flags)
    {
        $this->regex = $regex;
        $this->delimiter = $delimiter;
        $this->flags = $flags;
    }

    /**
     * @param  string $data
     * @return Regex
     * @throws RegexFormatException
     */
    public static function create($data)
    {
        if (empty($data)) {
            return new self('', '', '');
        }

        $delimiter = $data[0];
        if ($delimiter == "(") {
            $delimiter = ")";
        }

        $j = strlen($data) - 1;

        while (0 < $j) {
            if ($delimiter == $data[$j]) {
                break;
            }
            $j--;
        }

        if (0 === $j) {
            throw RegexFormatException::create($data);
        }

        $regex = substr($data, 1, $j - 1);
        $flags = substr($data, $j + 1);

        return new self($regex, $delimiter, $flags);
    }
}
