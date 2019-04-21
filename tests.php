<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

$code = <<<'CODE'
<?php 
array_uintersect_uassoc($arr, function($a){return $a;}, ...$_POST);
CODE;


try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect($code);

    print_r($alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}
