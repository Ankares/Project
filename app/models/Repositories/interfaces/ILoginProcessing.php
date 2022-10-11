<?php

namespace App\Models\Repositories\Interfaces;
use App\Models\LoginModel;

interface ILoginProcessing
{
    public function checkUser(LoginModel $user, $email, $password);
    public function getUserBySession();
    public function getUserByEmail($email);
    public function auth($email);
    public function logOut();
}