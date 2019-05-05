<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-05
 * Time: 17:06
 */

namespace Chip\Tests;

use PhpParser\Node;
use PhpParser\ParserFactory;

class TestHelper
{
    public static function createNodeFromCode(string $code): Node
    {
        if (strpos($code, '<?php') === false) {
            $code = '<?php ' . $code;
        }

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $stmts = $parser->parse($code);

        return $stmts[0];
    }
}
