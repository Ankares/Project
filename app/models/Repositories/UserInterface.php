<?php

namespace App\Models\Repositories;

interface UserInterface
{
    public static function loadDB();
    public function add();
    public function checkUser($email, $id = []);
    public function updateUser($id, $email, $name, $surname, $gender, $status);
    public function setData($email, $name, $surname, $gender, $status);
    public function validation();
    public function getAllData();
    public function getDataByID($id);
    public function deleteByID($id);
}
