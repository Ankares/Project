<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Repositories\LoginRepository;
use App\Services\LoginService;
use Twig\Environment;

class DashboardController extends Controller
{
    public function __construct(
        private readonly LoginRepository $repository,
        private readonly LoginService $loginService,
        private readonly Environment $twig,
    ) {
    }

    public function index()
    {
        $this->loginService->authorization();
        if (!isset($_SESSION['auth'])) {
            header('Location: /login/index');

            return;
        }
        if (isset($_FILES['file'], $_POST['id'])) {
            $data = $this->loginService->uploadFileAction($_FILES['file'], $_POST['id']);
            $success = $data['success'];
            $error = $data['error'];
        }
        $user = $this->repository->getUserByEmail($_SESSION['email']);
        $files = $this->repository->getFiles($_SESSION['id']);

        echo $this->twig->render('/dashboard/dashboard.php.twig', ['user' => $user, 'success' => $success ?? null, 'error' => $error ?? null, 'files' => $files]);
    }

    public function showFiles($userID)
    {
        if ($userID == $_SESSION['id']) {
            $files = $this->repository->getFiles($userID);
            $user = $this->repository->getUserById($userID);
        }
        echo $this->twig->render('/dashboard/showFiles.php.twig', ['files' => $files ?? null, 'user' => $user ?? null]);
    }

    public function deleteFile()
    {
        $this->loginService->deleteFileFromDashboard($_POST['pathToDelete']);
    }

    public function exit()
    {
        if (isset($_POST['logout'])) {
            $this->loginService->logOut();
            exit();
        }
    }
}
