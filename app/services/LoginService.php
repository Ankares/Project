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

    public function registerUser(LoginModel $validationFields)
    {
        $hashedPassword = password_hash($validationFields->userData['password'], PASSWORD_DEFAULT);
        $this->repository->addUser($validationFields, $hashedPassword);
    }

    public function checkLoginData(LoginModel $validationFields, $email, $password)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        !isset($userfromDB['email']) ? $validationFields->error['emailError'] = 'User is not found' : $validationFields->passwordVeryfied = password_verify($password, $userfromDB['password']);
    }

    public function checkRegisterData(LoginModel $validationFields, $email)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        isset($userfromDB['email']) ? $validationFields->error['emailError'] = 'User is already exist' : '';
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
