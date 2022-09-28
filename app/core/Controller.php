<?php

namespace App\Core;

class Controller
{   
    public function bootstrap($class): object
    {
        $serviceProvider = new ServiceProvider();
        $serviceProvider->bind($class, static fn() => new $class());
        return $serviceProvider->make($class);
    }

    public function view($view, $data = [])  {
        require_once 'app/views/' . $view . '.php';
    }
}

