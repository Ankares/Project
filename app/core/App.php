<?php

class App
{

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_UNSAFE_RAW));
        }
    }

    public function __construct() 
    {
        $url = $this->parseURL();
        
        if (isset($url)) {
            if (file_exists('app/controllers/' . ucfirst($url[0] . '.php'))) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                header('Location: /error404');
            }
        }

        require_once 'app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                header('Location: /error404');
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}