<?php
// coverage-badger.php
$inputFile = $argv[1];
$outputFile = $argv[2];
if (!file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}
$xml = new \SimpleXMLElement(file_get_contents($inputFile));
$metrics = $xml->xpath('//metrics');
$totalElements = 0;
$checkedElements = 0;
foreach ($metrics as $metric) {
    $totalElements += (int)$metric['elements'];
    $checkedElements += (int)$metric['coveredelements'];
}
$coverage = (int)(($totalElements === 0) ? 0 : ($checkedElements / $totalElements) * 100);
$template = file_get_contents(__DIR__ . '/templates/flat.svg');
$template = str_replace('{{ total }}', $coverage, $template);
$color = '#a4a61d';      // Default Gray
if ($coverage < 40) {
    $color = '#e05d44';  // Red
} elseif ($coverage < 60) {
    $color = '#fe7d37';  // Orange
} elseif ($coverage < 75) {
    $color = '#dfb317';  // Yellow
} elseif ($coverage < 90) {
    $color = '#a4a61d';  // Yellow-Green
} elseif ($coverage < 95) {
    $color = '#97CA00';  // Green
} elseif ($coverage <= 100) {
    $color = '#4c1';     // Bright Green
}
$template = str_replace('{{ total }}', $coverage, $template);
$template = str_replace('{{ color }}', $color, $template);
file_put_contents($outputFile, $template);
