<?php

namespace App\Models;

class UserModel
{  
    public $userData = [
        'name' => '',
        'email' => '',
        'gender' => '',
        'status' => ''
    ];
    public $error = '';
    public $userExists = false;
    
    public function setData($data)
    {
        foreach($data as $key => $value) {
            if(array_key_exists($key, $this->userData)) {
                $this->userData[$key] = $value;
            }
        }
    }

    public function validation(): string
    {
        if ($this->userExists != false) {
            return $this->error = 'User is already exist';
        }
        foreach(['emailValidation', 'nameValidation', 'genderValidation', 'statusValidation'] as $validator) {
            $this->$validator();
            if($this->error) break;
        }
        return $this->error;
    }

    private function emailValidation()
    {
        if (empty($this->userData['email'])) {
            return $this->error = 'Email is empty';
        } 
        if (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com|org|biz|info)$/", $this->userData['email'])) {
            return $this->error = 'Email is incorrect. Please try again';
        }
        
    }

    private function nameValidation() 
    {
        if (empty($this->userData['name'])) {
            return $this->error = 'Name is empty';
        } 
        if (!preg_match("/^([a-zA-Z]+) ([a-zA-Z]+)$/i", $this->userData['name'])) {
            return $this->error ='Name is incorrect. Please try again';
        }
    }

    private function genderValidation()   
    {
        if (!isset($this->userData['gender'])) {
            return $this->error ='Please select your gender';
        }
        
    }

    private function statusValidation()  
    {
        if (!isset($this->userData['status'])) {
            return $this->error ='Please select your status';
        }
    }
}
