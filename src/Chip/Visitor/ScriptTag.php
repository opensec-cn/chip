<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/4/22
 * Time: 0:09
 */

namespace Chip\Visitor;

use Chip\BaseVisitor;
use PhpParser\Node;
use PhpParser\Node\Stmt\InlineHTML;

class ScriptTag extends BaseVisitor
{
    protected $checkNodeClass = [
        InlineHTML::class
    ];

    /**
     * @param InlineHTML $node
     */
    public function process($node)
    {
        if (stripos($node->value, '<script') !== false && $this->findUnsupportPHPTag($node->value)) {
            $this->message->warning($node, __CLASS__, '使用不支持的PHP标签，可能存在安全问题');
        }
    }

    /**
     * @param string $data
     */
    private function findUnsupportPHPTag($data)
    {
        libxml_disable_entity_loader(true);
        $dom = new \DOMDocument();
        while (($pos = stripos($data, '<script')) !== false) {
            $data = substr($data, $pos);

            if ($this->singleProcess($dom, $data)) {
                return true;
            }
            $data = substr($data, 7);
        }

        return false;
    }

    /**
     * @param \DOMDocument $dom
     * @param string $data
     * @return bool
     */
    private function singleProcess($dom, $data)
    {
        @$dom->loadHTML($data, LIBXML_NONET);

        foreach ($dom->getElementsByTagName("script") as $tag) {
            $language = $tag->attributes->getNamedItem("language");
            if ($language && strtolower($language->nodeValue) == 'php') {
                return true;
            }
        }
        return false;
    }
}
