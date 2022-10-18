<?php

namespace App\Models\Repositories\Interfaces;

use App\Models\LoginModel;

interface ILoginProcessing
{
    public function addUser(LoginModel $user, $hashedPassword, $solt);
    public function addFile($userId, $fileName, $filePath, $fileSize);
    public function addCookie($token, $email);
    public function getFiles($id);
    public function deleteFile($filePath);
    public function getUserByCookie($token);
    public function getUserByEmail($email);
    public function getUserById($id);
}
