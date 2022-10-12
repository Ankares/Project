<?php

namespace App\Core;

session_start();

use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Services\ServiceProvider;
use App\Services\FileUpload;
use App\Services\LoginService;
use App\Logs\LoggingFiles;
use App\Models\UserModel;
use App\Models\LoginModel;
use App\Models\Repositories\Interfaces\IUserProcessing;
use App\Models\Repositories\LoginRepository;
use App\Models\Repositories\UserRepository;
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
        $connection->bind(IUserProcessing::class, static fn (ServiceProvider $provider) => $provider->make(UserModel::class));
        $connection->bind(UserController::class, static fn (ServiceProvider $service) => new UserController($service->make(IUserProcessing::class), $service->make(UserRepository::class), $service->make(FileUpload::class), $service->make(LoggingFiles::class)));
        $connection->bind(LoginService::class, static fn (ServiceProvider $service) => new LoginService($service->make(LoginRepository::class)));
        $connection->bind(Environment::class, static fn () => new Environment(new FilesystemLoader('app/views')));
        $connection->bind(LoginController::class, static fn (ServiceProvider $service) => new LoginController($service->make(LoginModel::class), $service->make(LoginRepository::class), $service->make(LoginService::class), $service->make(Environment::class)));
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
