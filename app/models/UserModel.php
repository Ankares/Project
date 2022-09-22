<?php
  require 'DB.php';

  class UserModel {
    
    private $name;
    private $email;
    private $pass;
    private $re_pass;

    private $db = null;                

    public function __construct(){     
      $this->db = DB::getInstence();
    }

    public function setData($name,$email,$pass,$re_pass) {
      $this->name = $name;
      $this->email = $email;
      $this->pass = $pass;
      $this->re_pass = $re_pass;
    }

    public function addUser() {
      $sql = 'INSERT INTO users(name,email,password) VALUES(:name,:email,:password)';
      $query = $this->db->prepare($sql);
      $passHash = password_hash($this->pass, PASSWORD_DEFAULT);
      $query->execute(['name'=>$this->name, 'email'=>$this->email, 'password'=>$passHash]);
    }
  }