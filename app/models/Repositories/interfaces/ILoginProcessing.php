<?php

namespace App\Models\Repositories\Interfaces;

interface ILoginProcessing
{
    public function getUserBySession($session);
    public function getUserByEmail($email);
}
