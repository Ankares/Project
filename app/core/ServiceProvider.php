<?php

namespace App\Core;

class ServiceProvider 
{
    private $container = [];

    public function make(string $class) {
        return isset($this->container[$class]) ? $this->container[$class]() : new $class;
    }

    public function bind(string $class, \Closure $resolver) {
        $this->container[$class] = $resolver;
    }
}