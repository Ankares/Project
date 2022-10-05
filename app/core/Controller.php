<?php

namespace App\Core;

use App\Models\UserModel;

class Controller
{   
    public function view($view, $data = [])  {
        require_once 'app/views/' . $view . '.php';
    }
}

