<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-28
 * Time: 17:20
 */

namespace Chip\Traits\Walker;

use Chip\Exception\NodeTypeException;
use PhpParser\Node;

/**
 * Trait MethodWalker
 *
 * @package       Chip\Traits\Walker
 * @property-read $whitelistMethods
 * @method        getMethodName($node)
 */
trait MethodWalker
{
    protected $fname = '';

    /**
     * @param  Node\Expr\MethodCall $node
     * @return bool
     */
    public function beforeProcess($node)
    {
        try {
            $this->fname = $this->getMethodName($node);
            return in_array($this->fname, $this->getWhitelistMethods());
        } catch (NodeTypeException $e) {
            return false;
        }
    }

    protected function getWhitelistMethods()
    {
        if (property_exists($this, 'whitelistMethods')) {
            return $this->whitelistMethods;
        } else {
            return [];
        }
    }
}
