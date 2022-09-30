<?php

namespace App\Core;

use App\Controllers\User;
use App\Models\UserModel;
use App\Models\DB;
use App\Models\Repositories\IUserProcessing;
use App\Models\Repositories\UserRepository;

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

    private function bootstrap()
    {
        $connection = ServiceProvider::getInstance();
        $connection->bind(IUserProcessing::class, static fn(ServiceProvider $provider) => $provider->make(UserModel::class));
        $connection->bind(User::class, static fn(ServiceProvider $service) => new User($service->make(IUserProcessing::class), $service->make(UserRepository::class)));
    }

    public function run() 
    {
        $this->bootstrap();
        $url = $this->parseURL();
        
        if (isset($url)) {
            if (file_exists('app/controllers/' . ucfirst($url[0] . '.php'))) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                header('Location: /error404');
            }
        }

        $this->controller = ServiceProvider::getInstance()->make('App\Controllers\\'.$this->controller);
        // $this->controller = new ('App\Controllers\\'.$this->controller)();

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