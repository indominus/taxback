<?php

namespace App\Services;

class Container implements \ArrayAccess
{

    private $container;

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->container[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
