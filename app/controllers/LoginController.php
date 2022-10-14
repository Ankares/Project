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
        $errors = null;
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->loginService->checkLoginData($this->user, $_POST['email'], $_POST['password']);
            $this->user->loginValidation();
            if (true === $this->user->checkErrors()) {
                $currentUser = $this->repository->getUserByEmail($_POST['email']);
                $this->loginService->auth($currentUser['id']);
            } else {
                $errors = $this->user->error;
            }
        }
        if (isset($_SESSION['user'])) {
            header('Location: /login/dashboard');

            return;
        }
        echo $this->twig->render('/login/index.php.twig', ['errors' => $errors, 'post' => $_POST]);
    }

    public function registration()
    {
        $success = null;
        $errors = null;
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $this->loginService->checkRegisterData($this->user, $_POST['email']);
            $this->user->registerValidation();
            if (true === $this->user->checkErrors()) {
                $this->loginService->registerUser($this->user);
                $success = 'Successful registration';
            } else {
                $errors = $this->user->error;
            }
        }
        if (isset($_SESSION['user'])) {
            header('Location: /login/dashboard');

            return;
        }

        echo $this->twig->render('/login/registration.php.twig', ['success' => $success, 'errors' => $errors, 'post' => $_POST]);
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
