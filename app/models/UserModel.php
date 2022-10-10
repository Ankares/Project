<?php

namespace App\Models;
use App\Models\Repositories\Traits\ValidationTrait;
class UserModel
{  
    use ValidationTrait;
    
    public $userData = [
        'name' => '',
        'email' => '',
        'gender' => '',
        'status' => ''
    ];
    public $error = '';
    public $userExists = false;
    
    
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
