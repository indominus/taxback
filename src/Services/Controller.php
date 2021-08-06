<?php

namespace App\Services;

class Controller
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getDB(): DB
    {
        return $this->container->offsetGet(DB::class);
    }

    public function renderView($template, array $data = [])
    {

        ob_get_clean();

        extract($data);
        extract(['templateName' => $template]);

        include ROOT . 'views/layout.php';

        return ob_get_contents();
    }
}
