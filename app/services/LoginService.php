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
        $solt = uniqid();
        $strongPassword = $validationFields->userData['password'].$solt;
        $hashedPassword = password_hash($strongPassword, PASSWORD_DEFAULT);
        $this->repository->addUser($validationFields, $hashedPassword, $solt);
    }

    public function checkLoginData(LoginModel $validationFields, $email, $password)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        if (!isset($userfromDB['email'])) {
            $validationFields->error['emailError'] = 'User is not found';
            return;
        } 
        $passwordToCheck = $password.$userfromDB['solt'];
        $verification = password_verify($passwordToCheck, $userfromDB['password']);
        $validationFields->passwordVeryfied = $verification;
    }

    public function checkRegisterData(LoginModel $validationFields, $email)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        isset($userfromDB['email']) ? $validationFields->error['emailError'] = 'User is already exist' : '';
    }

    public function setSession($user)
    {
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];
    }

    public function setCookie($user) 
    {
        $email = $user['email'];
        $token = md5(uniqid().time());
        setcookie('token', $token, time() + 3600*24*7, '/');
        $this->repository->addCookie($token, $email);
        header('Location: /login/dashboard');
    }

    public function authorization() 
    {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
            if (isset($_COOKIE['token'])) {
                $token = $_COOKIE['token'];
                $user = $this->repository->getUserByCookie($token);
                $this->setSession($user);  
            } 
        }
    }

    public function logOut()
    {
        setcookie('token', '', time(), '/');
        unset($_SESSION);
        session_destroy();
        header('Location: /login/index');
    }
}
