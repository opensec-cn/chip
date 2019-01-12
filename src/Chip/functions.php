<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 2:49
 */

namespace Chip;

function strip_whitespace(string $code)
{
    $code = "<?php {$code}";
    $code = php_strip_whitespace('string://' . $code);

    return trim(substr($code, 5));
}
