<?php
require 'vendor/autoload.php';

$code = <<<'CODE'
<?php
eval($b);
eval('phpinfo();');
`$_GET[1]`;
CODE;


$chip = new \Chip\Chip();
$chip->visitor([
    \Chip\Visitor\Eval_::class,
    \Chip\Visitor\Shell::class
])->detect($code);

print_r($chip->getAlerts());
