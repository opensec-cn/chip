<?php
require 'vendor/autoload.php';

$code = <<<'CODE'
<?php
preg_replace();
CODE;


$chip = new \Chip\Chip();
$chip->visitor([
    \Chip\Visitor\Eval_::class,
    \Chip\Visitor\Shell::class,
    \Chip\Visitor\Assert_::class,
    \Chip\Visitor\PregExec::class
])->detect($code);

print_r($chip->getAlarms());
