<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

$code = <<<'CODE'
<?php
//('preg_re' . 'place')('/.*/e', $a, $b);
('a' . $f)();
CODE;


try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect($code);

    print_r((array)$alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}
