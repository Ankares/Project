<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Repositories\LoginRepository;
use App\Services\LoginService;
use Twig\Environment;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginRepository $repository,
        private readonly LoginService $loginService,
        private readonly Environment $twig,
    ) {
    }

    public function index()
    {
        if ($this->loginService->checkBlockTime()) {
            echo $this->twig->render('/login/index.php.twig', ['errors' => [], 'blocked' => true]);

            return;
        }
        if (!empty($_POST)) {
            $errors = $this->loginService->loginAction($_POST);
        }
        if (isset($_SESSION['auth'])) {
            header('Location: /dashboard');

            return;
        }
        echo $this->twig->render('/login/index.php.twig', ['errors' => $errors ?? null, 'post' => $_POST, 'blocked' => false]);
    }

    public function registration()
    {
        $errors = $this->loginService->registrationAction($_POST);
        if (isset($_SESSION['auth'])) {
            header('Location: /dashboard');

            return;
        }
        echo $this->twig->render('/login/registration.php.twig', ['errors' => $errors ?? null, 'post' => $_POST]);
    }
}
