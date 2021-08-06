<?php

namespace App;

use RuntimeException;

class Config
{

    /**
     * @var array
     */
    private $settings;

    /**
     * @param $file
     * @throws RuntimeException
     */
    public function load($file): void
    {
        if (!file_exists($file)) {
            throw new RuntimeException(sprintf('Invalid configuration file specified [%s].', $file));
        }

        $this->settings = parse_ini_file($file, true);
    }

    public function get($key)
    {
        return $this->settings[$key] ?? null;
    }
}
