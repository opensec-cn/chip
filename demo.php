<?php
require 'vendor/autoload.php';
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeTraverser;

$code = <<<'CODE'
<?php 
$a = function() {};
CODE;

$nameResolver = new NameResolver();
$traverser = new NodeTraverser();
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $stmts = $parser->parse($code);
    $traverser->addVisitor($nameResolver);
    $traverser->traverse($stmts);

    $dumper = new NodeDumper();
    echo $dumper->dump($stmts);
} catch (Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}
