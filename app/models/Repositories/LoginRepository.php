<?php

namespace App\Models\Repositories;
use App\Models\DB;
use App\Models\LoginModel;
use App\Models\Repositories\Interfaces\ILoginProcessing;

class LoginRepository implements ILoginProcessing
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

    public function getUserBySession()
    {
        $id = $_SESSION['user'];
        $sql = $this->db->query("SELECT * FROM regUsers WHERE id = '$id'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getUserByEmail($email)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE email = '$email'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
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