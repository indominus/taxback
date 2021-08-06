<?php

use App\Kernel;

include_once './bootstrap.php';

$kernel = new Kernel();

try {
    http_response_code(200);
    echo $kernel->run();
} catch (Exception $e) {
    http_response_code(500);
    echo "<h2>{$e->getMessage()}";
}
