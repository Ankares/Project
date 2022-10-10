<?php

namespace App\Models\Repositories;
use App\Models\DB;
use App\Models\LoginModel;

class LoginRepository
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function checkUser(LoginModel $user, $email, $password)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE email = '$email'");
        $userfromDB = $sql->fetch(\PDO::FETCH_ASSOC);
        if(!isset($userfromDB['email'])) {
            $user->userExist = false;
        } else {
            $user->passwordVeryfied = password_verify($password, $userfromDB['password']);
        }
    }

    public function getUser()
    {
        $email = $_COOKIE['login'];
        $sql = $this->db->query("SELECT * FROM regUsers WHERE email = '$email'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function auth($email) 
    {
        setcookie('login', $email, time() + 3600 * 24, '/');
        header('Location: /login/dashboard');
    }

    public function logOut() 
    {
        setcookie('login', $_COOKIE['login'], time() - 3600 * 24, '/');
        unset($_COOKIE['login']);
        header('Location: /login');
    }
}