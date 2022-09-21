<?php

require './app/core/App.php';
require './app/core/Controller.php';

    $app = new App();


require './app/models/DB.php';

$obj = DB::getInstence();
