<?php
$f = fopen('1.txt', 'wb');

foreach(glob('/path/to/document/*.html') as $filename) {
    $html = file_get_contents($filename);

    if(preg_match('|<div class="methodsynopsis dc-description">(.+?)</div>|s', $html, $matches)) {
        $data = $matches[0];
        $data = preg_replace('/\s+/', ' ', strip_tags($data));

        if (strpos($data, 'callable') !== false) {
            $title = basename($filename);

            fwrite($f, "$title : $data\n");
            fflush($f);
            echo "$data\n";
        }
    }
}


fclose($f);