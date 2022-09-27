<?php

namespace App\Core;
use App\Models;

interface  Instance  {
    public function getClass();
}

class Controller {   

    public $action;

    public function __construct(Instance $action){
        $this->action = $action;   
    }

    public function init() {
        return $this->action;
    }
}

class User implements Instance {
    public function getClass() {
        $users = new Models\UserModel(new Models\Repositories\UserRepository);
        return $users->initRepo();
    }
}

class View implements Instance {
    
    public $route;
    public $data;

    public function __construct($route, $data) {
        $this->route = $route;
        $this->data = $data;
    }

    public function getClass()  {
        $view = new View($this->route, $this->data);
        $view->view($this->route, $this->data);
    }

    public function view($view, $data = [])  {
        require_once 'app/views/' . $view . '.php';
    }
}