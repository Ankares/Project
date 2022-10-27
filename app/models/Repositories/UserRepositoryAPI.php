<?php

namespace App\Models\Repositories;
use App\Models\UserModel;

class UserRepositoryAPI{
    
    private $curl = null;
    
    public function setOpt()
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users?access-token=".$_ENV['ACCESS_TOKEN'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
          ));
    }
    
    public function add(UserModel $user)
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($_POST)
        ));
        curl_exec($this->curl);
        curl_close($this->curl);
    }

    // checking for uniq email (id check for editing current user => can use own email, not others)
    public function checkUser(UserModel $user, $email, $id = '')
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));
        $response = curl_exec($this->curl);
        $data = json_decode($response, true);
        foreach($data as $users) {
            if($users['email'] == $email && $users['id'] != $id) {
                $user->userExists = true;
            }
        }
        curl_close($this->curl);
    }

    public function getAllData()
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($this->curl);
        return json_decode($response, true);
        curl_close($this->curl);
    }

    public function getDataByID($id)
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=".$_ENV['ACCESS_TOKEN'],
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($this->curl);
        return json_decode($response, true);
        curl_close($this->curl);
    }

    public function updateUser(UserModel $user, $id)
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=".$_ENV['ACCESS_TOKEN'],
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($_POST)
        ));
        curl_exec($this->curl);
        curl_close($this->curl);
    }

    public function deleteByID($id)
    {
        $this->curl = curl_init();
        $this->setOpt();
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=".$_ENV['ACCESS_TOKEN'],
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ));
        curl_exec($this->curl);    
        curl_close($this->curl); 
    }
}