<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019/1/12
 * Time: 5:26 PM
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class PregExec extends BaseVisitor
{
    protected $check_node_class = [FuncCall::class];

    protected $preg_functions = ['preg_replace', 'preg_filter', 'eregi_replace', 'ereg_replace'];

    /**
     * @param FuncCall $node
     * @return bool
     */
    public function checkNode($node)
    {
        return parent::checkNode($node) && in_array($node->name, $this->preg_functions);
    }

    /**
     * @param FuncCall $node
     */
    public function process($node)
    {

    }

    protected function simpleParseRegex($regex)
    {
        $delimiter = $regex[0];


    }
}