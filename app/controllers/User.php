<?php

class User extends Controller
{
    public function index() 
    {
        $data = [];

        if(isset($_POST['email']) && isset($_POST['name'])) {
            $user = $this->model('UserModel');
            $user->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            
            $valid = $user->validation();
            if($valid == 'Correct data') {
                $user->addUser();
            } else {
                $data['error'] = $valid;
            }
        }
        $this->view('user/index', $data);
    }

    public function list()
    {
        $user = $this->model('UserModel');
        $data['users'] = $user->getUsers();
        $this->view('user/list', $data);
    }
    
}