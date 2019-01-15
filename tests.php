<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

$code = <<<'CODE'
<?php
include 'dir/' . ($upload . ('.php' . $n)) . '.php'; 
CODE;


try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect($code);

    print_r((array)$alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}
