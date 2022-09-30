<?php

namespace App\Models\Repositories;
use App\Models\DB;
use App\Models\UserModel;

class UserRepository implements IUserProcessing{

    private $db = null;
    protected $checkUserExistence = '';

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function add()
    {
        $sql = 'INSERT INTO users(email, name, surname, gender, status) VALUES(:email, :name, :surname, :gender, :status)';
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$this->email, 'name'=>$this->name, 'surname'=>$this->surname, 'gender'=>$this->gender, 'status'=>$this->status]);
    }

    public function add2(UserModel $user)
    {
        $sql = 'INSERT INTO users(email, name, surname, gender, status) VALUES(:email, :name, :surname, :gender, :status)';
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$user->email, 'name'=>$user->name, 'surname'=>$user->surname, 'gender'=>$user->gender, 'status'=>$user->status]);
    }

    // checking for uniq email (id check for editing current user => can use own email, not others)
    public function checkUser($email, $id = '')
    {
        $sql = $this->db->query("SELECT * FROM users WHERE email = '$email' AND id != '$id'");
        $user = $sql->fetch(\PDO::FETCH_ASSOC);
        if (isset($user['email'])) {
            $this->checkUserExistence = 'User is already exist';
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

    public function getDataByID2($id)
    {
        $sql = $this->db->query("SELECT * FROM users WHERE id = '$id'");
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
        $model = new UserModel();
        $model->setData(...$data);

        return $model;
    }

    public function updateUser($id, $email, $name, $surname, $gender, $status)
    {
        $sql = "UPDATE users SET email = :email, name = :name, surname = :surname, gender = :gender, status = :status WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$email, 'name'=>$name, 'surname'=>$surname, 'gender'=>$gender, 'status'=>$status, 'id'=>$id]);
    }

    public function deleteByID($id)
    {
        $this->db->query("DELETE FROM users WHERE id = '$id'");
    }
    
}