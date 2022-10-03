<?php

namespace App\Controllers;
use App\Models;
use App\Core\Controller;
use App\Core\ServiceProvider;
use App\Models\Repositories\IUserProcessing;
use App\Models\Repositories\UserRepository;
use App\Models\UserModel;

class UserController extends Controller
{
    private $data = [];

    public function __construct(
        private UserModel $user,
        private UserRepository $repository
    ) {}

    public function index() 
    {
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->repository->checkUser($this->user, $_POST['email']);
            $this->user->validation();
            if (empty($this->user->error)) {
                $this->repository->add($this->user);
                $this->data['success'] = 'User successfully added';
            } else {
                $this->data['error'] = $this->user->error;
            }
        }
        $this->view('user/index', $this->data);
    }

    public function list()
    {
        $this->data['users'] = $this->repository->getAllData();
        $this->view('user/list', $this->data);
    }

    public function edit($id)
    {
        if (isset($_POST['id'])) {
            $this->user->setData($_POST);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['id']);
            $this->user->validation();
            if (empty($this->user->error)) {
                $this->repository->updateUser($this->user, $_POST['id']);   
                $this->data['success'] = 'Successfully updated';
            } else {
                $this->data['error'] = $this->user->error;
            }            
        }
        $this->data['user'] = $this->repository->getDataByID($id);
        $this->view('user/edit', $this->data);
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $this->repository->deleteByID($_POST['delete']);
        }
        header('Location: /user/list');
    }
}