<?php

namespace App\Services;

use App\Logs\LoggingFiles;
use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;
use App\Services\FileUpload;

class LoginService
{
    public function __construct(
        private readonly LoginModel $user,
        private readonly LoginRepository $repository,
        private readonly FileUpload $fileUploader,
        private readonly LoggingFiles $fileLog
    ) {
    }

    public function registerUser(LoginModel $validationFields)
    {
        $solt = uniqid();
        $strongPassword = $validationFields->userData['password'].$solt;
        $hashedPassword = password_hash($strongPassword, PASSWORD_DEFAULT);
        $this->repository->addUser($validationFields, $hashedPassword, $solt);
    }

    public function checkLoginData(LoginModel $validationFields, $email, $password)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        if (!isset($userfromDB['email'])) {
            $validationFields->error['emailError'] = 'User is not found';
            return;
        } 
        $passwordToCheck = $password.$userfromDB['solt'];
        $verification = password_verify($passwordToCheck, $userfromDB['password']);
        $validationFields->passwordVeryfied = $verification;
    }

    public function checkRegisterData(LoginModel $validationFields, $email)
    {
        $userfromDB = $this->repository->getUserByEmail($email);
        isset($userfromDB['email']) ? $validationFields->error['emailError'] = 'User is already exist' : '';
    }

    public function loginAction($post)
    {
        $errors = null;
        if (isset($post['email'])) {
            $this->user->setData($post);
            $this->checkLoginData($this->user, $post['email'], $post['password']);
            $this->user->loginValidation();
            if (true === $this->user->checkErrors()) {
                $currentUser = $this->repository->getUserByEmail($post['email']);
                isset($post['remember']) ? $this->setCookie($currentUser) : $this->setSession($currentUser);
            } else {
                $errors = $this->user->error;
            }
        }
        return $errors;
    }

    public function registrationAction($post)
    {
        $errors = null;
        if (isset($post['email'])) {
            $this->user->setData($post);
            $this->checkRegisterData($this->user, $post['email']);
            $this->user->registerValidation();
            if (true === $this->user->checkErrors()) {
                $this->registerUser($this->user);
                $currentUser = $this->repository->getUserByEmail($post['email']);
                $this->setSession($currentUser);
            } else {
                $errors = $this->user->error;
            }
        }
        return $errors;
    }

    public function uploadFileAction($file, $id)
    {
        $error = null;
        $success = null;
        $fileInfo = $this->fileUploader->checkFile($file);
        if (empty($fileInfo['error'])) {
            $pathToDB = $this->fileUploader->moveFile($file);
            $this->repository->addFile($id, $fileInfo['fileName'], $pathToDB, $fileInfo['fileSize']);
            $this->fileLog->info('',[$file, 'Info: File successfully added']);
            $success = 'Successfully updated';
        } else {
            $error = $fileInfo['error'];
            $this->fileLog->error('',[$_FILES['file'], $error]); 
        } 

        return [
            'error' => $error, 
            'success' => $success
        ];
    }

    public function deleteFileFromDashboard($path) 
    {
        if (isset($path)) {
            $this->repository->deleteFile($path);
            $this->fileUploader->deleteFromDir($path);
            $this->fileUploader->deleteEmptyDir($path);
        }
        header ('Location: /login/showFiles/'.$_POST['userId']);
    }

    public function setSession($user)
    {
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];
    }

    public function setCookie($user) 
    {
        $email = $user['email'];
        $token = md5(uniqid().time());
        setcookie('token', $token, time() + 3600*24*7, '/');
        $this->repository->addCookie($token, $email);
        header('Location: /login/dashboard');

        return;
    }

    public function checkSession() 
    {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
            $data = $this->authentication();
            if ($data['cookieStatus'] === true) {
                $this->setSession($data['user']);  
            }           
        }
    }
    
    private function authentication()
    {
        $cookieStatus = null;
        $currentUser = null;
        if (isset($_COOKIE['token'])) {
            $possibleUser = $this->repository->getUserByCookie($_COOKIE['token']);     
            if(!empty($possibleUser) && $possibleUser['cookie'] === $_COOKIE['token']) {
                $cookieStatus = true;
                $currentUser = $possibleUser;
            } else {
                $cookieStatus = false;
                $currentUser = false;
            }
        }

        return [
            'cookieStatus' => $cookieStatus, 
            'user' => $currentUser
        ];
    }

    public function authorization() 
    {
        $data = $this->authentication();
        if ($data['cookieStatus'] === false) {
            header('Location: /login/cookieError');

            return;
        }
        if (!isset($_SESSION['auth'])) {
            header('Location: /login/index');
            
            return;
        } 
    }

    public function loginRedirection()
    {
        if (isset($_SESSION['auth'])) {
            header('Location: /login/dashboard');

            return;
        }
    }

    public function logOut()
    {
        setcookie('token', '', time(), '/');
        unset($_SESSION);
        session_destroy();
        header('Location: /login/index');
    }
}
