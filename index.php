<?php
require 'app/core/App.php';
require 'app/core/Controller.php';
require 'vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__))->load();

$app = new App();