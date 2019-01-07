<?php
require 'vendor/autoload.php';

use \PhpParser\NodeTraverser;

$code = <<<'CODE'
<?php
eval(base64_decode() . $b);
CODE;


$chip = new \Chip\Chip();
$chip->traveller([
    \Chip\Traveller\Eval_::class
])->detect($code);
