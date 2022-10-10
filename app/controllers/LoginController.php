<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;

class LoginController extends Controller
{
    public function __construct(
        private LoginModel $user,
        private LoginRepository $repository
    ) {}
    
    public function index()
    {
        $data = null;
        if(isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['password']);
            $this->user->validation();
            if(empty($this->user->error)) {
                $this->repository->auth($_POST['email']);
                $data['success'] = 'Successfull authorization';
            } else {
                $data['error'] = $this->user->error;
            }
        }
        $this->view('login/index', $data);
    }

    public function dashboard()
    {
        $data = null;
        if (isset($_COOKIE['login'])) {
            $data['user'] = $this->repository->getUser();
        }
        if (isset($_POST['logout'])) {
            $this->repository->logOut();
            exit();
        }
        $this->view('login/dashboard', $data);
    }
}