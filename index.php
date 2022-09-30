<?php



require 'vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__))->load();

$app = new App\Core\App();
$app->run();