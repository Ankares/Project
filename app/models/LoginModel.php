<?php

namespace App\Models;
use App\Models\Repositories\Traits\ValidationTrait;

class LoginModel
{  
    use ValidationTrait;

    public $userData = [
        'name' => '',
        'email' => '',
        'password' => ''
    ];
    public $error = '';
    public $userExist = true;
    public $passwordVeryfied = true;

    public function validation(): string
    {
        if ($this->userExist == false) {
            return $this->error = 'User is not found';
        }
        foreach(['emailValidation', 'passwordValidation'] as $validator) {
            $this->$validator();
            if ($this->error) break;
        }
        return $this->error;
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
