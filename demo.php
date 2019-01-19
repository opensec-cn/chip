<?php
require 'vendor/autoload.php';
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

$code = <<<'CODE'
<?php
create_function($a, $b);
CODE;

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $stmts = $parser->parse($code);

    $dumper = new NodeDumper();
    echo $dumper->dump($stmts);
} catch (Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
