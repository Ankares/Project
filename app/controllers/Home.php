<?php

namespace App\Controllers;
use App\Core;

class Home
{
    public function initView($route, $data = []) {
        $view = new Core\Controller(new Core\View($route, $data));
        $viewInit = $view->init($route, $data);
        return $viewInit->getClass();
    }
    
    public function index() {
       
        $this->initView('home/index');
    }
}