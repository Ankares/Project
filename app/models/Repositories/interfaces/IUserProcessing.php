<?php

namespace App\Models\Repositories\Interfaces;

use App\Models\UserModel;

interface IUserProcessing
{
    public function add(UserModel $class);
    public function addFile($userId, $fileName, $path,  $size);
    public function checkUser(UserModel $class, $email, $id = '');
    public function updateUser(UserModel $class, $id);
    public function getAllData();
    public function getDataByID($id);
    public function deleteByID($id);
    public function deleteFileById($filePath);
}
