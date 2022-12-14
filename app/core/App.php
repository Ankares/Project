<?php

namespace App\Core;

session_start();

use App\Services\ServiceProvider;
use App\Models\UserModel;
use App\Models\Repositories\Interfaces\IUserProcessing;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class App
{
    public const DEFAULT_CONTROLLER = 'Home';
    public const DEFAULT_METHOD = 'index';

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_UNSAFE_RAW));
        }
    }

    private function bootstrap()
    {
        $connection = ServiceProvider::getInstance();
        $connection->bind(IUserProcessing::class, static fn (ServiceProvider $service) => $service->make(UserModel::class));
        $connection->bind(Environment::class, static fn () => new Environment(new FilesystemLoader('app/views')));
    }

    public function run()
    {
        $controllerName = self::DEFAULT_CONTROLLER;
        $methodName = self::DEFAULT_METHOD;

        $this->bootstrap();
        $url = $this->parseURL();

        if (isset($url)) {
            if (file_exists('app/controllers/' . ucfirst($url[0] . 'Controller.php'))) {
                $controllerName = ucfirst($url[0]);
                unset($url[0]);
            } else {
                header('Location: /error404');
            }
        }

        $controller = ServiceProvider::getInstance()->make('App\Controllers\\' . $controllerName . 'Controller');

        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $methodName = $url[1];
                unset($url[1]);
            } else {
                header('Location: /error404');
            }
        }

        $params = $url ? array_values($url) : [];
        call_user_func_array([$controller, $methodName], $params);
    }
}
