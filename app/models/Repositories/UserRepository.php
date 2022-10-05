<?php

namespace App\Models\Repositories;
use App\Models\DB;
use App\Models\UserModel;

class UserRepository implements IUserProcessing{

    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function add(UserModel $user)
    {
        $sql = 'INSERT INTO users(email, name, surname, gender, status) VALUES(:email, :name, :surname, :gender, :status)';
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$user->userData['email'], 'name'=>$user->userData['name'], 'surname'=>$user->userData['surname'], 'gender'=>$user->userData['gender'], 'status'=>$user->userData['status']]);
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
        $sql = $this->db->query("SELECT * FROM users");
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDataByID($id)
    {
        $sql = $this->db->query("SELECT * FROM users WHERE id = '$id'");
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateUser(UserModel $user, $id)
    {
        $sql = "UPDATE users SET email = :email, name = :name, surname = :surname, gender = :gender, status = :status WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$user->userData['email'], 'name'=>$user->userData['name'], 'surname'=>$user->userData['surname'], 'gender'=>$user->userData['gender'], 'status'=>$user->userData['status'], 'id'=>$id]);
    }

    public function deleteByID($id)
    {
        $this->db->query("DELETE FROM users WHERE id = '$id'");
    }
    
}