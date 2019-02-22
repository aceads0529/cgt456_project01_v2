<?php

const INCLUDE_TEMPLATE = 'include_once __DIR__ . \'%s\';';

$scripts = get_php_files();
$file = fopen('includes.php', 'w');

fwrite($file, '<?php' . PHP_EOL);

if ($scripts) {
    fwrite($file, PHP_EOL);

    foreach ($scripts as $script) {
        fwrite($file, $script);
        fwrite($file, PHP_EOL);
    }
}

fclose($file);

function get_php_files($root = '')
{
    $result = array();

    if (is_dir(__DIR__ . $root)) {
        foreach (scandir(__DIR__ . $root) as $item) {
            if ($item[0] === '.')
                continue;
            $result = array_merge($result, get_php_files($root . '\\' . $item));
        }

        while (end($result) === '')
            array_pop($result);

        $result[] = '';

    } elseif (pathinfo($root, PATHINFO_DIRNAME) != '\\'
        && pathinfo($root, PATHINFO_EXTENSION) === 'php'
        && pathinfo($root, PATHINFO_FILENAME) != 'index') {
        $result = [sprintf(INCLUDE_TEMPLATE, $root)];
    }

    return $result;
}
