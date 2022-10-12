<?php

namespace App\Models;

class LoginModel
{
    public $userData = [
        'name' => '',
        'email' => '',
        'repeatEmail' => '',
        'password' => '',
        'repeatPassword' => ''
    ];
    public $error = '';
    public $passwordVeryfied = true;

    public function setData($data)
    {
        foreach ($data as $key => $value) {
            array_key_exists($key, $this->userData) ? $this->userData[$key] = $value : '';
        }
    }

    private function validation($array) {
        foreach($array as $validator) {
            $this->$validator();
            if ($this->error) {
                break;
            }
        }
        return $this->error;
    }
    
    public function loginValidation()
    {
        $this->validation(['emailValidation','passwordValidation']);        
    }

    public function registerValidation()
    {
        $this->validation(['nameValidation', 'matchingEmail', 'emailValidation','matchingPassword', 'passwordValidation']);
    }

    private function emailValidation()
    {
        empty($this->userData['email']) ? $this->error = 'Email is empty' : '';
        !preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->userData['email']) ? $this->error = 'Email is incorrect. Please try again' : '';
    }

    private function matchingEmail()
    {
        $this->userData['email'] !== $this->userData['repeatEmail'] ? $this->error = 'Email does not match' : '';
    }

    private function nameValidation()
    {
        empty($this->userData['name']) ? $this->error = 'Name is empty' : '';
        !preg_match('/^([a-zA-Z]+) ([a-zA-Z]+)$/i', $this->userData['name']) ? $this->error = 'Name is incorrect. Please try again' : '';
    }

    private function passwordValidation()
    {
        empty($this->userData['password']) ? $this->error = 'Password is empty' : '';
        $this->passwordVeryfied == false ? $this->error = 'Password is incorrect. Please try again' : '';
    }

    private function matchingPassword()
    {
        $this->userData['password'] !== $this->userData['repeatPassword'] ? $this->error = 'Password does not match' : '';  
        !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $this->userData['password']) ? $this->error = 'Password should contain special characters' : '';
        !preg_match("/[A-Z]/", $this->userData['password']) ? $this->error = 'Password should contain english capital character' : '';
        !preg_match("/[0-9]/", $this->userData['password']) ? $this->error = 'Password should contain digits' : '';
    }
}
