<?php

namespace App\Models\Repositories;

use App\Models\DB;
use App\Models\UserModel;

class UserRepository implements Interfaces\IUserProcessing
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function add(UserModel $user)
    {
        $sql = 'INSERT INTO users(email, name, gender, status) VALUES(:email, :name, :gender, :status)';
        $query = $this->db->prepare($sql);
        $query->execute(['email' => $user->userData['email'], 'name' => $user->userData['name'], 'gender' => $user->userData['gender'], 'status' => $user->userData['status']]);
    }

    public function addFile($userId, $fileName, $path, $size)
    {
        $sql = 'INSERT INTO files(userId, file, path, size) VALUES(:userId, :file, :path, :size)';
        $query = $this->db->prepare($sql);
        $query->execute(['userId' => $userId, 'file' => $fileName, 'path' => $path, 'size' => $size]);
    }

    // checking for uniq email (id check for editing current user => can use own email, not others)
    public function checkUser(UserModel $user, $email, $id = '')
    {
        $sql = $this->db->query("SELECT * FROM users WHERE email = '$email' AND id != '$id'");
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
        if (isset($data['email'])) {
            $user->userExists = true;
        }
    }

    public function getAllData()
    {
        $sql = $this->db->query('SELECT * FROM users');

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDataByID($id)
    {
        $sql = $this->db->query("SELECT * FROM users WHERE id = '$id'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserFiles($id)
    {
        $sql = $this->db->query("SELECT * FROM files WHERE userId = '$id'");

        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateUser(UserModel $user, $id)
    {
        $sql = 'UPDATE users SET email = :email, name = :name, gender = :gender, status = :status WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute(['email' => $user->userData['email'], 'name' => $user->userData['name'], 'gender' => $user->userData['gender'], 'status' => $user->userData['status'], 'id' => $id]);
    }

    public function deleteByID($id)
    {
        $this->db->query("DELETE FROM users WHERE id = '$id'");
    }

    public function deleteFileById($filePath)
    {
        $this->db->query("DELETE FROM files WHERE path = '$filePath'");
    }
}
