<?php

function get_next_block(&$array, $find) {
    if(!is_array($find)) {
        $find = [$find];
    }

    $last = [];
    do {
        $block = current($array);
        if (in_array($block, $find)) {
            next($array);
            return trim(implode('', $last));
        }
        $last[] = $block;
        $last[] = ' ';
    } while (next($array));

    return null;
}

$table = [];
foreach(file('1.txt') as $line) {
    $blocks = explode(' ', $line);
    $blocks = array_filter($blocks, function($i) {
        return !in_array($i, ['', ' ']);
    });

    $filename = get_next_block($blocks, ':');

    $name = get_next_block($blocks, ['(', '([']);

    if (preg_match('/^[a-z0-9_]+$/', trim($name)) !== 1) {
        continue;
    }

    $args = [];
    while($arg = get_next_block($blocks, [',', ')', '[,', '],'])) {
        $args[] = $arg;
    }

    $has_dotdotdot = false;
    foreach ($args as $key => $arg) {
        if (strpos($arg, '...') !== false) {
            $has_dotdotdot = true;
        } elseif (strpos($arg, 'callable') !== false) {
            $pos = $has_dotdotdot ? $key - count($args) : $key;
            $table[] = [
                'function' => $name,
                'pos' => $pos,
                'arg' => $arg
            ];
        }
    }
}

file_put_contents('../src/Chip/Schema/FunctionWithCallable.php', var_export($table, true));