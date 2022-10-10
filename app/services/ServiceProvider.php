<?php

namespace App\Services;

class ServiceProvider 
{
    private static $connection = null;
    private $container = [];

    public static function  getInstance()
    {
        $class = static::class;
        if (!isset(self::$connection[$class])) {
            self::$connection[$class] = new static();
        }

        return self::$connection[$class];
    }

    public function make(string $class) 
    {
        return isset($this->container[$class]) ? $this->container[$class]($this) : new $class;
    }

    public function bind(string $class, \Closure $resolver) 
    {
        $this->container[$class] = $resolver;
    }
}