<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-01-28
 * Time: 18:36
 */

namespace Chip\Visitor;


use Chip\BaseVisitor;
use function Chip\dump_node;
use Chip\Exception\ArgumentsFormatException;
use Chip\Traits\TypeHelper;
use Chip\Traits\Variable;
use Chip\Traits\Walker\FunctionWalker;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;

class FilterVar extends BaseVisitor
{
    use Variable, TypeHelper, FunctionWalker;

    protected $checkNodeClass = [
        FuncCall::class
    ];

    protected $whitelistFunctions = [
        'filter_var',
        'filter_var_array'
    ];

    protected $whitelistConstant = [
        "FILTER_FLAG_NONE",
        "FILTER_REQUIRE_SCALAR",
        "FILTER_REQUIRE_ARRAY",
        "FILTER_FORCE_ARRAY",
        "FILTER_NULL_ON_FAILURE",
        "FILTER_VALIDATE_INT",
        "FILTER_VALIDATE_BOOLEAN",
        "FILTER_VALIDATE_FLOAT",
        "FILTER_VALIDATE_REGEXP",
        "FILTER_VALIDATE_DOMAIN",
        "FILTER_VALIDATE_URL",
        "FILTER_VALIDATE_EMAIL",
        "FILTER_VALIDATE_IP",
        "FILTER_VALIDATE_MAC",
        "FILTER_DEFAULT",
        "FILTER_UNSAFE_RAW",
        "FILTER_SANITIZE_STRING",
        "FILTER_SANITIZE_STRIPPED",
        "FILTER_SANITIZE_ENCODED",
        "FILTER_SANITIZE_SPECIAL_CHARS",
        "FILTER_SANITIZE_FULL_SPECIAL_CHARS",
        "FILTER_SANITIZE_EMAIL",
        "FILTER_SANITIZE_URL",
        "FILTER_SANITIZE_NUMBER_INT",
        "FILTER_SANITIZE_NUMBER_FLOAT",
        "FILTER_SANITIZE_MAGIC_QUOTES",
        "FILTER_FLAG_ALLOW_OCTAL",
        "FILTER_FLAG_ALLOW_HEX",
        "FILTER_FLAG_STRIP_LOW",
        "FILTER_FLAG_STRIP_HIGH",
        "FILTER_FLAG_STRIP_BACKTICK",
        "FILTER_FLAG_ENCODE_LOW",
        "FILTER_FLAG_ENCODE_HIGH",
        "FILTER_FLAG_ENCODE_AMP",
        "FILTER_FLAG_NO_ENCODE_QUOTES",
        "FILTER_FLAG_EMPTY_STRING_NULL",
        "FILTER_FLAG_ALLOW_FRACTION",
        "FILTER_FLAG_ALLOW_THOUSAND",
        "FILTER_FLAG_ALLOW_SCIENTIFIC",
        "FILTER_FLAG_SCHEME_REQUIRED",
        "FILTER_FLAG_HOST_REQUIRED",
        "FILTER_FLAG_PATH_REQUIRED",
        "FILTER_FLAG_QUERY_REQUIRED",
        "FILTER_FLAG_IPV4",
        "FILTER_FLAG_IPV6",
        "FILTER_FLAG_NO_RES_RANGE",
        "FILTER_FLAG_NO_PRIV_RANGE",
        "FILTER_FLAG_HOSTNAME",
        "FILTER_FLAG_EMAIL_UNICODE"
    ];

    /**
     * @param FuncCall $node
     * @throws ArgumentsFormatException
     */
    public function process($node)
    {
        if ($this->fname === 'filter_var' && count($node->args) >= 3) {
            $filter = $node->args[1];
            $options = $node->args[2];

            $this->filterVar($node, $filter, $options);
        } elseif ($this->fname === 'filter_var_array' && count($node->args) >= 2) {
            $options = $node->args[1];

            $this->filterVarArray($node, $options);
        }
    }

    /**
     * @param FuncCall $node
     * @param Arg $filter
     * @param Arg $options
     * @throws ArgumentsFormatException
     */
    protected function filterVar($node, $filter, $options)
    {
        if ($this->isSafeFilter($filter->value) || $this->isSafeOptions($options->value)) {
            return;
        }

        $options = $options->value;
        if ($this->isVariable($options)) {
            $this->message->danger($node, __CLASS__, "{$this->fname}第3个参数不固定，可能存在代码执行的隐患");
            return;
        } elseif ($this->isArray($options)) {
            foreach ($options->items as $item) {
                if (!$this->isString($item->key)) {
                    $this->message->warning($node, __CLASS__, "{$this->fname}第3个参数畸形, 可能存在命令执行漏洞");
                    break;
                }

                if (strtolower($item->key->value) === 'options' && !$this->isClosure($item->value)) {
                    $this->message->warning($node, __CLASS__, "{$this->fname}中，回调函数请使用闭包函数表达");
                    break;
                }
            }
            return;
        } elseif ($this->hasDynamicExpr($options)) {
            $this->message->danger($node, __CLASS__, "{$this->fname}第3个参数畸形，可能存在命令执行漏洞");
            return;
        }
    }

    /**
     * @param FuncCall $node
     * @param Arg $options
     */
    protected function filterVarArray($node, $options)
    {
        $options = $options->value;
        if ($this->isSafeOptions($options)) {
            return;
        }

        if ($this->isVariable($options)) {
            $this->message->danger($node, __CLASS__, "{$this->fname}第2个参数不固定，可能存在代码执行的隐患");
            return;
        } elseif ($this->isArray($options)) {
            foreach ($options->items as $item) {
                if ($this->isSafeFilter($item->value)) {
                    continue;
                }

                if ($this->isArray($item->value)) {
                    $subFilter = null;
                    $subOptions = null;
                    foreach ($item->value->items as $subItem) {
                        if (!$this->isString($subItem->key)) {
                            $this->message->warning($node, __CLASS__, "{$this->fname}第2个参数畸形, 可能存在命令执行漏洞");
                            break 2;
                        }

                        if (strtolower($subItem->key->value) === 'options') {
                            $subOptions = $subItem->value;
                        } elseif (strtolower($subItem->key->value) === 'filter') {
                            $subFilter = $subItem->value;
                        }
                    }

                    if ($subFilter && $subOptions) {
                        if ($this->isSafeFilter($subFilter)) {
                            continue;
                        }

                        if (!$this->isClosure($subOptions)) {
                            $this->message->warning($node, __CLASS__, "{$this->fname}中，回调函数请使用闭包函数表达");
                            break;
                        }
                    }
                } else {
                    $this->message->warning($node, __CLASS__, "{$this->fname}第2个参数畸形，可能存在命令执行漏洞");
                    break;
                }
            }
            return;
        } elseif ($this->hasDynamicExpr($options)) {
            $this->message->danger($node, __CLASS__, "{$this->fname}第2个参数畸形，可能存在命令执行漏洞");
            return;
        }
    }

    protected function isSafeOptions($node)
    {
        if ($this->isConstant($node) && in_array($node->name->toString(), $this->whitelistConstant)) {
            return true;
        }

        if ($this->isMixConstant($node)) {
            return true;
        }

        return false;
    }

    protected function isSafeFilter($node)
    {
        return $this->isConstant($node) && in_array($node->name->toString(), $this->whitelistConstant);
    }
}