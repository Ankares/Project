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
    public $errors = '';
    
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
                $this->errors = "$key is empty"; 
            }
        }
        if ($this->checkUserExistence != '') {
            $this->errors = $this->checkUserExistence;
        }
        $this->nameValidation();
        $this->surnameValidation();
        $this->emailValidation();
        $this->genderValidation();
        $this->statusValidation();

        return $this->errors;
    }

    private function emailValidation(): void
    {
        if (empty($this->email)) {
            $this->errors = 'Email is empty';
        } elseif(!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->email)) {
            $this->errors = 'Email is incorrect. Please try again';
        }
        
    }

    private function nameValidation(): void 
    {
        if (empty($this->name)) {
            $this->errors = 'Name is empty';
        } elseif (!preg_match("/^[a-zA-Z]+$/i", $this->name)) {
            $this->errors ='Name is incorrect. Please try again';
        }
    }

    private function surnameValidation(): void 
    {
        if (empty($this->surname)) {
            $this->errors = 'Surname is empty';
        } elseif (!preg_match("/^[a-zA-Z]+$/i", $this->surname)) {
            $this->errors ='Surname is incorrect. Please try again';
        }   
    }

    private function genderValidation(): void  
    {
        if (!isset($this->gender)) {
            $this->errors ='Please select your gender';
        }
        
    }

    private function statusValidation(): void  
    {
        if (!isset($this->status)) {
            $this->errors ='Please select your status';
        }
    }

}
