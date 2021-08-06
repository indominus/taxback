<?php

namespace App;

use App\Services\DB;
use App\Services\Config;
use App\Services\Container;

class App
{

    public function __construct()
    {

        $container = new Container();
        $container->offsetSet(Config::class, new Config());
        $container->offsetGet(Config::class)->load(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');

        $dbConfig = $container->offsetGet(Config::class)->get('pgsql');
        $container->offsetSet(DB::class, new DB($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password']));

    }
}
