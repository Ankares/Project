<?php

namespace App\Models;

class LoginModel
{
    public $userData = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];
    public $error = '';
    public $userExist = true;
    public $passwordVeryfied = true;

    public function setData($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->userData)) {
                $this->userData[$key] = $value;
            }
        }
    }

    public function validation(): string
    {
        foreach (['emailValidation', 'passwordValidation'] as $validator) {
            $this->$validator();
            if ($this->error) {
                break;
            }
        }

        return $this->error;
    }

    private function emailValidation()
    {
        if (empty($this->userData['email'])) {
            return $this->error = 'Email is empty';
        }
        if (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->userData['email'])) {
            return $this->error = 'Email is incorrect. Please try again';
        }
        if ($this->userExist == false) {
            return $this->error = 'User is not found';
        }
    }

    private function nameValidation()
    {
        if (empty($this->userData['name'])) {
            return $this->error = 'Name is empty';
        }
        if (!preg_match('/^([a-zA-Z]+) ([a-zA-Z]+)$/i', $this->userData['name'])) {
            return $this->error = 'Name is incorrect. Please try again';
        }
    }

    private function passwordValidation()
    {
        if (empty($this->userData['password'])) {
            return $this->error = 'Password is empty';
        }
        if ($this->passwordVeryfied == false) {
            return $this->error = 'Password is incorrect. Please try again';
        }
    }
}
