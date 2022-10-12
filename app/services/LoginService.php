<?php

namespace App\Services;

use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;

class LoginService
{
    public function __construct(
        private readonly LoginRepository $repository
    ) {
    }

    public function checkUser(LoginModel $validationFields, $email, $password)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        if (!isset($userfromDB['email'])) {
            $validationFields->userExist = false;
        } else {
            $validationFields->passwordVeryfied = password_verify($password, $userfromDB['password']);
        }
    }

    public function auth($id)
    {
        $_SESSION['user'] = $id;
        header('Location: /login/dashboard');
    }

    public function logOut()
    {
        unset($_SESSION['user']);
        header('Location: /login/index');
        session_destroy();
    }
}
