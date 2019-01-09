<?php
require 'vendor/autoload.php';

use \PhpParser\NodeTraverser;

$code = <<<'CODE'
<?php
eval($b);
eval('phpinfo();');
`$_GET[1]`;
CODE;


$chip = new \Chip\Chip();
$chip->traveller([
    \Chip\Traveller\Eval_::class,
    \Chip\Traveller\Shell::class
])->detect($code);

print_r($chip->getAlerts());
