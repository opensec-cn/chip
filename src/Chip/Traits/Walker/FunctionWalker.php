<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-28
 * Time: 16:04
 */

namespace Chip\Traits\Walker;


use Chip\Exception\NodeTypeException;
use PhpParser\Node;

trait FunctionWalker
{
    protected $fname = '';

    /**
     * @param Node\Expr\FuncCall $node
     * @return bool
     */
    public function beforeProcess($node)
    {
        try {
            $this->fname = $this->getFunctionName($node);
            return in_array($this->fname, $this->getWhitelistFunctions());
        } catch (NodeTypeException $e) {
            return false;
        }
    }

    protected function getWhitelistFunctions()
    {
        if (property_exists($this, 'whitelistFunctions')) {
            return $this->whitelistFunctions;
        } else {
            return [];
        }
    }
}