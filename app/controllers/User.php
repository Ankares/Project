<?php

class User extends Controller
{
    public function index() 
    {
        $data = [];

        if(isset($_POST['email']) && isset($_POST['name'])) {
            
            $user = $this->model('UserModel');
            $user->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            
            $checkUser = $user->checkUser($_POST['email']);
            $valid = $user->validation();

            if($checkUser == 'User is already exist') {
                $data['error'] = $checkUser;
            } else {
                if($valid == 'Correct data') {
                    $user->addUser();
                } else {
                    $data['error'] = $valid;
                }
            }  
        }
        $this->view('user/index', $data);
    }

    public function list()
    {
        $user = $this->model('UserModel');
        
        if(isset($_POST['delete'])) {
            $user->deleteUser($_POST['delete']);
        }
        $data['users'] = $user->getUsers();

        $this->view('user/list', $data);
    }
    
}