<?php

namespace App;

use App\Services\DB;
use App\Services\XMLParser;
use App\Services\Container;
use App\Services\DirectoryScan;
use App\Controller\IndexController;

class Kernel
{

    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {

        $this->container = new Container();
        $this->container->offsetSet(Config::class, new Config());
        $this->container->offsetGet(Config::class)->load(ROOT . 'config.ini');

        $dbConfig = $this->container->offsetGet(Config::class)->get('pgsql');
        $this->container->offsetSet(DB::class, new DB($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password']));

        $this->container->offsetSet(XMLParser::class, new XMLParser());
        $this->container->offsetSet(DirectoryScan::class, new DirectoryScan());
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function run()
    {
        return call_user_func_array((new IndexController($this->container)), []);
    }
}
