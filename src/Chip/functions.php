<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 2:49
 */

namespace Chip;

use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard as PrettyPrinter;

function strip_whitespace(string $code)
{
    $code = "<?php {$code}";
    $code = php_strip_whitespace('string://' . $code);

    return trim(substr($code, 5));
}

function dump_node(Node $node)
{
    $prettyPrinter = new PrettyPrinter();

    $code = $prettyPrinter->prettyPrint([$node]);
    return strip_whitespace($code);
}