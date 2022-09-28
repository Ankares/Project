<?php

namespace App\Controllers;
use App\Core\Controller;

class Error404 extends Controller
{   
    public function index() {
        $this->view('error404/index');
    }
}