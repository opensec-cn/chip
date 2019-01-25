<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

$code = <<<'CODE'
<?php
(base64_decode("abcd"))();
CODE;


try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect($code);

    print_r($alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}
