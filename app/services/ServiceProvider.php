<?php

namespace App\Services;

use ReflectionClass;

class ServiceProvider
{
    private static $connection = null;
    private $container = [];

    public static function getInstance()
    {
        $class = static::class;
        if (!isset(self::$connection[$class])) {
            self::$connection[$class] = new static();
        }

        return self::$connection[$class];
    }

    public function make(string $class)
    {
        return isset($this->container[$class]) ? $this->container[$class]($this) : $this->resolver($class);
    }

    public function bind(string $class, \Closure $resolver)
    {
        $this->container[$class] = $resolver;
    }

    private function resolver(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }
        $parametrs = $constructor->getParameters();
        if ($parametrs === []) {
            return $reflectionClass->newInstance();
        }
        $newInstanceParams = [];
        foreach ($parametrs as $parametr) {
            $newInstanceParams[] = $parametr->getType() === null ? $parametr->getDefaultValue() : $this->make($parametr->getType()->getName());
        }

        return $reflectionClass->newInstanceArgs($newInstanceParams);
    }
}
