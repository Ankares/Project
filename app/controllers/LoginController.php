<?php

namespace App\Controllers;

session_start();

use App\Core\Controller;
use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;
use Twig\Environment;

class LoginController extends Controller
{
    public function __construct(
        private LoginModel $user,
        private LoginRepository $repository,
        private Environment $twig
    ) {}
    
    public function index()
    {
        $error = null;
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['password']);
            $this->user->validation();
            if (empty($this->user->error)) {
                $currentUser = $this->repository->getUserByEmail($_POST['email']);
                $this->repository->auth($currentUser['id']);
            } else {
                $error = $this->user->error;
            }
        }
        if (isset($_SESSION['user'])) {
            header('Location: /login/dashboard');
        }
        echo $this->twig->render('/login/index.php', ["error" => $error]);
    }

    public function dashboard()
    {
        $user = null;
        if (isset($_SESSION['user'])) {
            $user = $this->repository->getUserBySession();  
        } else {
            header('Location: /login/index');
        }
        if (isset($_POST['logout'])) {
            $this->repository->logOut();
            exit();
        }
        echo $this->twig->render('/login/dashboard.php', ["user" => $user]);
    }
}