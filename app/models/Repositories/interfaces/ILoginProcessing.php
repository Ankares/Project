<?php

namespace App\Models\Repositories\Interfaces;

interface ILoginProcessing
{
    public function getUserByCookie($login, $key);
    public function getUserByEmail($email);
}
