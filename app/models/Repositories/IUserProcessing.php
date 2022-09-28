<?php

namespace App\Models\Repositories;

interface IUserProcessing
{
    public function add();
    public function checkUser($email, $id = []);
    public function updateUser($id, $email, $name, $surname, $gender, $status);
    public function getAllData();
    public function getDataByID($id);
    public function deleteByID($id);
}
