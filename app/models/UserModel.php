<?php

namespace App\Models;
use App\Models\Repositories\UserRepository;

class UserModel extends UserRepository
{  
    protected $name;
    protected $surname;
    protected $email;
    protected $gender;
    protected $status;
    public $error = '';
    
    public function setData(string $email, string $name, string $surname, string $gender, string $status)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
        $this->status = $status;
    }

    public function validation(): string
    {
        foreach(get_object_vars($this) as $key => $value) {
            if($value === null) {
                return $this->error = "$key is empty"; 
            }
        }
        if ($this->checkUserExistence != '') {
            return $this->error = $this->checkUserExistence;
        }
        $this->surnameValidation();
        $this->nameValidation();
        $this->emailValidation();
        $this->genderValidation();
        $this->statusValidation();

        return $this->error;
    }

    private function emailValidation()
    {
        if (empty($this->email)) {
            return $this->error = 'Email is empty';
        } 
        if (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->email)) {
            return $this->error = 'Email is incorrect. Please try again';
        }
        
    }

    private function nameValidation() 
    {
        if (empty($this->name)) {
            return $this->error = 'Name is empty';
        } 
        if (!preg_match("/^[a-zA-Z]+$/i", $this->name)) {
            return $this->error ='Name is incorrect. Please try again';
        }
    }

    private function surnameValidation() 
    {
        if (empty($this->surname)) {
            return $this->error = 'Surname is empty';
        } 
        if (!preg_match("/^[a-zA-Z]+$/i", $this->surname)) {
            return $this->error ='Surname is incorrect. Please try again';
        }   
    }

    private function genderValidation()   
    {
        if (!isset($this->gender)) {
            return $this->error ='Please select your gender';
        }
        
    }

    private function statusValidation()  
    {
        if (!isset($this->status)) {
            return $this->error ='Please select your status';
        }
    }

}
