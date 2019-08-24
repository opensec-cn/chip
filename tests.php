<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect('<?php usort($a, $b);');

    print_r($alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}