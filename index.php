<?php
require 'vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(__DIR__))->load();

require_once './app/core/App.php';
require_once './app/core/Controller.php';

    $app = new App();