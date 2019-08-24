<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019/1/12
 * Time: 5:26 PM
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use Chip\Exception\RegexFormatException;
use Chip\Structure\Regex;
use Chip\Traits\TypeHelper;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node\Expr\FuncCall;

class PregExec extends BaseVisitor
{
    use TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $whitelistFunctions = [
        'preg_replace',
        'preg_filter',
    ];

    /**
     * @param  FuncCall $node
     * @throws RegexFormatException
     */
    public function process($node)
    {
        if (empty($node->args)) {
            return;
        }
        $fname = $this->fname;

        $arg = $node->args[0]->value;
        if ($this->isString($arg)) {
            if ($this->isDangerRegex($arg->value)) {
                $this->storage->danger($node, __CLASS__, "{$fname}中正则表达式包含e模式，可能存在远程代码执行的隐患");
                return;
            }
        } elseif ($this->isPureArray($arg)) {
            foreach ($arg->items as $item) {
                if ($this->isDangerRegex($item->value->value)) {
                    $this->storage->danger($node, __CLASS__, "{$fname}中正则表达式包含e模式，可能存在远程代码执行的隐患");
                    return;
                }
            }
        } else {
            $this->storage->danger($node, __CLASS__, "{$fname}第一个参数不是静态字符串，可能存在远程代码执行的隐患");
            return;
        }
    }

    /**
     * @param $data
     * @return bool
     * @throws RegexFormatException
     */
    protected function isDangerRegex($data)
    {
        $regex = Regex::create($data);
        return strpos($regex->flags, 'e') !== false;
    }
}
