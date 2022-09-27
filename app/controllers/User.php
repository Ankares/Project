<?php

class User extends Controller
{
    public function index() 
    {
        $data = [];

        $model = new \UserModel;
        $users = $model->init();

        if (isset($_POST['email']) && isset($_POST['name'])) {

            $users->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            
            $checkUser = $users->checkUser($_POST['email']);
            $valid = $users->validation();

            if ($checkUser == 'User is already exist') {
                $data['error'] = $checkUser;
            } else {
                if ($valid == 'Correct data') {
                    $users->add();
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
        $model = new \UserModel;
        $users = $model->init();

        $data['users'] = $users->getAllData();

        $this->view('user/list', $data);
    }

    public function edit($id)
    {
        $model = new \UserModel;
        $users = $model->init();
        $currUser = $users->getDataByID($id);

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
            $users->deleteByID($_POST['delete']);
        }

        $data['user'] = $users->deleteByID($id);

        $this->view('user/edit', $data);
    }
    
}