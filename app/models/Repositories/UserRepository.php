<?php

namespace App\Models\Repositories;
use App\Models\UserModel;

class UserRepository implements IUserProcessing{
    
    private $curl = null;
    private $accessToken = '96eedf4ca052d9e7a52cf5afe705ea35c03ea6be4e084a1f89a467964638df6d';
    
    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users?access-token=$this->accessToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
          ));
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }
    
    public function add(UserModel $user)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($_POST)
        ));
        curl_exec($this->curl);
    }

    // checking for uniq email (id check for editing current user => can use own email, not others)
    public function checkUser(UserModel $user, $email, $id = '')
    {
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
    }

    public function getAllData()
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($this->curl);
        return json_decode($response, true);
    }

    public function getDataByID($id)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=$this->accessToken",
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($this->curl);
        return json_decode($response, true);
    }

    public function updateUser(UserModel $user, $id)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=$this->accessToken",
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($_POST)
        ));
        curl_exec($this->curl);
    }

    public function deleteByID($id)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "https://gorest.co.in/public/v2/users/$id?access-token=$this->accessToken",
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ));
        curl_exec($this->curl);     
    }
}