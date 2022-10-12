<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;
use App\Services\LoginService;
use Twig\Environment;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginModel $user,
        private readonly LoginRepository $repository,
        private readonly LoginService $loginService,
        private readonly Environment $twig
    ) {
    }

    public function index()
    {
        $error = null;
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->loginService->checkUser($this->user, $_POST['email'], $_POST['password']);
            $this->user->loginValidation();
            if (empty($this->user->error)) {
                $currentUser = $this->repository->getUserByEmail($_POST['email']);
                $this->loginService->auth($currentUser['id']);
            } else {
                $error = $this->user->error;
            }
        }
        if (isset($_SESSION['user'])) {
            header('Location: /login/dashboard');

            return;
        }
        echo $this->twig->render('/login/index.php.twig', ['error' => $error, 'post' => $_POST]);
    }

    public function registration() 
    {   
        $success = null;
        $error = null;
        if(isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->user->registerValidation();
            if (empty($this->user->error)) {
                $this->loginService->registerUser($this->user);
                $success = 'Successful registration';
            } else {
                $error = $this->user->error;
            }
        }
        if (isset($_SESSION['user'])) {
            header('Location: /login/dashboard');

            return;
        }
        echo $this->twig->render('/login/registration.php.twig', ['success' => $success, 'error' => $error, 'post' => $_POST]);
    }

    public function dashboard()
    {
        $user = null;
        if (!isset($_SESSION['user'])) {
            header('Location: /login/index');

            return;
        }
        $user = $this->repository->getUserBySession($_SESSION['user']);
        echo $this->twig->render('/login/dashboard.php.twig', ['user' => $user]);
    }

    public function exit()
    {
        if (isset($_POST['logout'])) {
            $this->loginService->logOut();
            exit();
        }
    }
}
