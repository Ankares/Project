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

    public function addUser(LoginModel $user, $hashedPassword, $solt)
    {
        $sql = 'INSERT INTO regUsers(email, name, password, solt) VALUES(:email, :name, :password, :solt)';
        $query = $this->db->prepare($sql);
        $query->execute(['email' => $user->userData['email'], 'name' => $user->userData['name'], 'password' => $hashedPassword, 'solt' => $solt]);
    }

    public function addFile($userId, $fileName, $filePath, $fileSize)
    {
        $sql = 'INSERT INTO regUsersFiles(userId, file, path, size) VALUES(:userId, :file, :path, :size)';
        $query = $this->db->prepare($sql);
        $query->execute(['userId' => $userId, 'file' => $fileName, 'path' => $filePath, 'size' => $fileSize]);
    }

    public function addCookie($token, $email)
    {
        $this->db->query("UPDATE regUsers SET cookie = '$token' WHERE email = '$email'");
    }

    public function setLoginAttemptsData($ip, $attempts)
    {
        $sql = "INSERT INTO loginAttempts(userIP, attempts) VALUES(:userIP, :attempts) ON DUPLICATE KEY UPDATE attempts = '$attempts'";
        $query = $this->db->prepare($sql);
        $query->execute(['userIP' => $ip, 'attempts' => $attempts]);
    }

    public function getLoginAttemptsData($ip)
    {
        $sql = $this->db->query("SELECT * FROM loginAttempts WHERE userIP = '$ip'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateBlockTime($time, $ip)
    {
        $this->db->query("UPDATE loginAttempts SET blockTime = '$time' WHERE userIP = '$ip'");
    }

    public function clearBlockTime($ip)
    {
        $this->db->query("UPDATE loginAttempts SET blockTime = null WHERE userIP = '$ip'");
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

    public function getUserByCookie($token)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE cookie = '$token'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sql = $this->db->query("SELECT * FROM regUsers WHERE id = '$id'");

        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
}
