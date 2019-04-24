<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-04-24
 * Time: 11:56
 */

namespace Chip\Tracer;

use PhpParser\Node;

class CallStack extends \SplStack
{
    /**
     * @param Node $value
     */
    public function push($value)
    {
        if ($value instanceof Node) {
            parent::push($value);
        }
    }
}
