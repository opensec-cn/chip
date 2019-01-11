<?php
require 'vendor/autoload.php';

$code = <<<'CODE'
<?php
assert(1);
CODE;


$chip = new \Chip\Chip();
$chip->visitor([
    \Chip\Visitor\Eval_::class,
    \Chip\Visitor\Shell::class,
    \Chip\Visitor\Assert_::class
])->detect($code);

print_r($chip->getAlarms());
