<?php

namespace App\Models\Repositories\Traits;

trait ValidationTrait
{
    public function setData($data)
    {
        foreach($data as $key => $value) {
            if(array_key_exists($key, $this->userData)) {
                $this->userData[$key] = $value;
            }
        }
    }
    
    private function emailValidation()
    {
        if (empty($this->userData['email'])) {
            return $this->error = 'Email is empty';
        } 
        if (!preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.(ru|com)$/", $this->userData['email'])) {
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
}