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

    public function addUser(LoginModel $user, $hashedPassword)
    {
        $sql = 'INSERT INTO regUsers(email, name, password) VALUES(:email, :name, :password)';
        $query = $this->db->prepare($sql);
        $query->execute(['email' => $user->userData['email'], 'name' => $user->userData['name'], 'password' => $hashedPassword]);
    }

    public function addFile($userId, $fileName, $filePath, $fileSize)
    {
        $sql = 'INSERT INTO regUsersFiles(userId, file, path, size) VALUES(:userId, :file, :path, :size)';
        $query = $this->db->prepare($sql);
        $query->execute(['userId' => $userId, 'file' => $fileName, 'path' => $filePath, 'size' => $fileSize]);
    }

    public function getFiles($id)
    {
        $sql = $this->db->query("SELECT * FROM regUsersFiles WHERE userId = '$id'");

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteFile($filePath)
    {
        $this->db->query("DELETE FROM regUsersFiles WHERE path = '$filePath'");
    }

    public function getUserByEmail($email)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE email = '$email'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserBySession($session)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE id = '$session'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
}
