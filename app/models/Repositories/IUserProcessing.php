<?php

namespace App\Models\Repositories;

use App\Models\UserModel;

interface IUserProcessing
{
    public function setOpt();
    public function add(UserModel $class);
    public function checkUser(UserModel $class, $email, $id = '');
    public function updateUser(UserModel $class, $id);
    public function getAllData();
    public function getDataByID($id);
    public function deleteByID($id);
}
