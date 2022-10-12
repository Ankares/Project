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

    public function registerUser(LoginModel $user) 
    {
        $user->userData['password'] = password_hash($user->userData['password'], PASSWORD_DEFAULT);
        $this->repository->addUser($user);   
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
