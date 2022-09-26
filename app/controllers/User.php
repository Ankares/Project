<?php

class User extends Controller
{
    public function index() 
    {
        $data = [];

        if (isset($_POST['email']) && isset($_POST['name'])) {
            
            $user = $this->model('UserModel');
            $user->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            
            $checkUser = $user->checkUser($_POST['email']);
            $valid = $user->validation();

            if ($checkUser == 'User is already exist') {
                $data['error'] = $checkUser;
            } else {
                if ($valid == 'Correct data') {
                    $user->addUser();
                    $data['success'] = 'User successfully added';
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
        $data['users'] = $users->getUsers();

        $this->view('user/list', $data);
    }

    public function edit($id)
    {
        $users = $this->model('UserModel');
        $currUser = $users->getUser($id);

        if (isset($_POST['id'])) {

            // checking for updating something, then validate and update user
            if ($_POST['email'] != $currUser['email'] || $_POST['name'] != $currUser['name'] || $_POST['surname'] != $currUser['surname'] || $_POST['gender'] != $currUser['gender'] || $_POST['status'] != $currUser['status']) {
                $checkUser = $users->checkUser($_POST['email'], $_POST['id']);
                if ($checkUser == 'User is already exist') {
                    $data['error'] = $checkUser;
                } else {
                    $users->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
                    $valid = $users->validation();
                    if ($valid == 'Correct data') {
                        $users->updateUser($_POST['id'], $_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);   
                        $data['success'] = 'Successfully updated';
                    } else {
                        $data['error'] = $valid;
                    }   
                }  
            } else {
                $data['error'] = 'You should change something to save the result';
            }
        }
    
        if (isset($_POST['delete'])) {
            $users->deleteUser($_POST['delete']);
        }

        $data['user'] = $users->getUser($id);

        $this->view('user/edit', $data);
    }
    
}