<?php

use App\Kernel;
use App\Services\DB;
use App\Services\XMLParser;
use App\Command\SyncCommand;
use App\Services\DirectoryScan;

include_once 'bootstrap.php';

$kernel = new Kernel();
$container = $kernel->getContainer();

$db = $container->offsetGet(DB::class);
$parser = $container->offsetGet(XMLParser::class);
$scan = $container->offsetGet(DirectoryScan::class);

$container->offsetSet(SyncCommand::class, new SyncCommand($db));

$data = [];
$files = $scan->scan(ROOT . 'storage');
foreach ($files AS $file) {
    $data[] = $parser->parse(file_get_contents($file));
}

$container->offsetGet(SyncCommand::class)->sync($data);

echo 'Command completed successful.' . PHP_EOL;
