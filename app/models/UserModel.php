<?php

require 'DB.php';

class UserModel
{

    private $name;
    private $surname;
    private $email;
    private $gender;
    private $status;

    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstence();
    }

    public function setData($email, $name, $surname, $gender, $status)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
        $this->status = $status;
    }

    public function validation() 
    {
        if (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->email))
            return 'Email is incorrect. Please try again';
        if (!preg_match("/^[a-zA-Z]{2,15}$/i", $this->name))
            return 'Name is incorrect. Please try again';
        if (!preg_match("/^[a-zA-Z]{2,15}$/i", $this->surname))
            return 'Surname is incorrect. Please try again';
        if (!isset($this->gender))
            return 'Please select your gender';
        if (!isset($this->status))
            return 'Please select your status';
        
        return 'Correct data';
    }

    public function addUser()
    {
        $sql = 'INSERT INTO users(email, name, surname, gender, status) VALUES(:email, :name, :surname, :gender, :status)';
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$this->email, 'name'=>$this->name, 'surname'=>$this->surname, 'gender'=>$this->gender, 'status'=>$this->status]);
    }

    // checking for uniq email (id check for editing current user => can use own email, not others)
    public function checkUser($email, $id = '')
    {
        $sql = $this->db->query("SELECT * FROM users WHERE email = '$email' AND id != '$id'");
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        if (isset($user['email'])) {
            return 'User is already exist';
        }
    }

    public function getUsers()
    {
        $sql = $this->db->query("SELECT * FROM users");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id)
    {
        $sql = $this->db->query("SELECT * FROM users WHERE id = '$id'");
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $email, $name, $surname, $gender, $status)
    {
        $sql = "UPDATE users SET email = :email, name = :name, surname = :surname, gender = :gender, status = :status WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['email'=>$email, 'name'=>$name, 'surname'=>$surname, 'gender'=>$gender, 'status'=>$status, 'id'=>$id]);
    }

    public function deleteUser($id)
    {
        $this->db->query("DELETE FROM users WHERE id = '$id'");
    }

}