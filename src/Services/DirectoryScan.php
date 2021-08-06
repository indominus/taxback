<?php

namespace App\Services;

use RegexIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class DirectoryScan
{

    public function scan($directory, $pattern = '#(.*).xml$#'): array
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $match = new RegexIterator($iterator, $pattern, RegexIterator::MATCH);
        foreach ($match AS $file) {
            $files[] = $file;
        }
        return $files;
    }
}
