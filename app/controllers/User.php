<?php

namespace App\Controllers;
use App\Models;
use App\Core\Controller;


class User extends Controller
{
    public $users;
    public $data = [];

    public function __construct() {
        $this->users = $this->bootstrap(Models\UserModel::class);
    }

    public function index() 
    {
        if (isset($_POST['email'])) {
            $this->users->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            $this->users->checkUser($_POST['email']);
            $this->users->validation();
            if (empty($this->users->errors)) {
                $this->users->add();
                $this->data['success'] = 'User successfully added';
            } else {
                $this->data['error'] = $this->users->errors;
            }
        }
        $this->view('user/index', $this->data);
    }

    public function list()
    {
        $this->data['users'] = $this->users->getAllData();
        $this->view('user/list', $this->data);
    }

    public function edit($id)
    {
        if (isset($_POST['id'])) {
            $this->users->setData($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);
            $this->users->checkUser($_POST['email'], $_POST['id']);
            $this->users->validation();
            if (empty($this->users->errors)) {
                $this->users->updateUser($_POST['id'], $_POST['email'], $_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['status']);   
                $this->data['success'] = 'Successfully updated';
            } else {
                $this->data['error'] = $this->users->errors;
            }            
        }
        $this->data['user'] = $this->users->getDataByID($id);
        $this->view('user/edit', $this->data);
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $this->users->deleteByID($_POST['delete']);
        }
        $this->view('user/edit', $this->data);
    }
}