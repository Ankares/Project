<?php

namespace App\Controllers;
use App\Models;
use App\Core;
use App\Models\Repositories\UserRepository;

class User
{
    public function init() {
        $user = new Core\Controller(new Core\User);
        $userInit = $user->init();
        return $userInit->getClass();
    }

     public function initView($route, $data) {
        $view = new Core\Controller(new Core\View($route, $data));
        $viewInit = $view->init();
        return $viewInit->getClass();
    }

    public function index() 
    {
        $data = [];
        $users = $this->init();

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

        $this->initView('user/index', $data);
    }

    public function list()
    {
        $users = $this->init();

        $data['users'] = $users->getAllData();

        $this->initView('user/list', $data);
    }

    public function edit($id)
    {
        $users = $this->init();

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
        $data['user'] = $users->getDataByID($id);
        
        $this->initView('user/edit', $data);
    }
}