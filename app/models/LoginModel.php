<?php

namespace App\Models;

class LoginModel
{
    public $userData = [
        'name' => '',
        'email' => '',
        'repeatEmail' => '',
        'password' => '',
        'repeatPassword' => '',
    ];
    public $error = [
        'nameError' => '',
        'emailError' => '',
        'repeatEmailError' => '',
        'passwordError' => '',
        'repeatPasswordError' => '',
    ];
    public $passwordVeryfied = true;

    public function setData($data)
    {
        foreach ($data as $key => $value) {
            array_key_exists($key, $this->userData) ? $this->userData[$key] = $value : '';
        }
    }

    private function validation($array)
    {
        foreach ($array as $validator) {
            $this->$validator();
        }

        return $this->error;
    }

    public function loginValidation()
    {
        $this->validation(['emailValidation', 'passwordValidation']);
    }

    public function registerValidation()
    {
        $this->validation(['nameValidation', 'matchingEmail', 'emailValidation', 'matchingPassword', 'passwordValidation']);
    }

    public function checkErrors()
    {
        $emptyErrors = true;
        foreach ($this->error as $k => $v) {
            $v != '' ? $emptyErrors = false : '';
        }
        if ($emptyErrors == true) {
            return true;
        }
    }

    private function emailValidation()
    {
        !preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->userData['email']) ? $this->error['emailError'] = 'Email is incorrect. Please try again' : '';
        empty($this->userData['email']) ? $this->error['emailError'] = 'Email is empty' : '';
    }

    private function matchingEmail()
    {
        $this->userData['email'] !== $this->userData['repeatEmail'] ? $this->error['repeatEmailError'] = 'Email does not match' : '';
    }

    private function nameValidation()
    {
        !preg_match('/^([a-zA-Z]+) ([a-zA-Z]+)$/i', $this->userData['name']) ? $this->error['nameError'] = 'Name is incorrect. Please try again' : '';
        empty($this->userData['name']) ? $this->error['nameError'] = 'Name is empty' : '';
    }

    private function passwordValidation()
    {
        $this->passwordVeryfied == false ? $this->error['passwordError'] = 'Password is incorrect. Please try again' : '';
        empty($this->userData['password']) ? $this->error['passwordError'] = 'Password is empty' : '';
    }

    private function matchingPassword()
    {
        !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $this->userData['password']) ? $this->error['passwordError'] = 'Password should contain special characters' : '';
        !preg_match('/[A-Z]/', $this->userData['password']) ? $this->error['passwordError'] = 'Password should contain english capital character' : '';
        !preg_match('/[0-9]/', $this->userData['password']) ? $this->error['passwordError'] = 'Password should contain digits' : '';
        $this->userData['password'] !== $this->userData['repeatPassword'] ? $this->error['repeatPasswordError'] = 'Password does not match' : '';
    }
}
