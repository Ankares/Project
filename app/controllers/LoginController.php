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
        private readonly Environment $twig,
    ) {
    }

    public function index()
    {
        $errors = null;
        $errors = $this->loginService->loginAction($_POST);
        $this->loginService->loginRedirection();
        echo $this->twig->render('/login/index.php.twig', ['errors' => $errors, 'post' => $_POST]);
    }

    public function registration()
    {
        $errors = null;
        $errors = $this->loginService->registrationAction($_POST);
        $this->loginService->loginRedirection();
        echo $this->twig->render('/login/registration.php.twig', ['errors' => $errors, 'post' => $_POST]);
    }

    public function dashboard()
    {
        $success = null;
        $error = null;
        if (isset($_FILES['file'], $_POST['id'])) {
            $data = $this->loginService->uploadFileAction($_FILES['file'], $_POST['id']);
            $success = $data['success'];
            $error = $data['error'];
        }
        $this->loginService->checkSession();
        $this->loginService->authorization(); 
        $user = $this->repository->getUserByEmail($_SESSION['email']);
        $files = $this->repository->getFiles($_SESSION['id']);

        echo $this->twig->render('/login/dashboard.php.twig', ['user' => $user, 'success' => $success, 'error' => $error, 'files' => $files]);
    }

    public function cookieError()
    {
        echo $this->twig->render('/login/cookieError.php.twig');
    }

    public function showFiles($userID)
    {   
        $files = null;
        $user = null;
        if ($userID == $_SESSION['id']) {
            $files = $this->repository->getFiles($userID);
            $user = $this->repository->getUserById($userID);
        }
        echo $this->twig->render('/login/showFiles.php.twig', ['files' => $files, 'user' => $user]);
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
