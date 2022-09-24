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
        $users = $this->model('UserModel');
        
        if(isset($_POST['id'])) {
            $oneUser = $users->getUser($_POST['id']);
            if($_POST['email'] != $oneUser['email'] || $_POST['name'] != $oneUser['name'] || $_POST['surname'] != $oneUser['surname'] || $_POST['gender'] != $oneUser['gender'] || $_POST['status'] != $oneUser['status']) {
                $users->updateUser($_POST['id'], $_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);    
            } else {
                $data['message'] = 'You should change something to save the result';
            }
        } 

        if(isset($_POST['delete'])) {
            $users->deleteUser($_POST['delete']);
        }

        $data['users'] = $users->getUsers();

        $this->view('user/list', $data);
    }
    
}