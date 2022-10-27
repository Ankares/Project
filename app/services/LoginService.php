<?php

namespace App\Services;

use App\Logs\LoggingAuth;
use App\Logs\LoggingFiles;
use App\Models\LoginModel;
use App\Models\Repositories\LoginRepository;

class LoginService
{
    public const BLOCKTIME = 15;

    public function __construct(
        private readonly LoginModel $user,
        private readonly LoginRepository $repository,
        private readonly FileUpload $fileUploader,
        private readonly LoggingFiles $fileLog,
        private readonly LoggingAuth $authLog
    ) {
    }

    private function incrementLoginAttempts($email)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = date('Y-m-d H:i:s');
        $endTime = date('Y-m-d H:i:s', strtotime(self::BLOCKTIME.'minutes'));
        $data = $this->repository->getLoginAttemptsData($ip);
        !$data ? $this->repository->setLoginAttemptsData($ip, 1) : $this->repository->setLoginAttemptsData($ip, $data['attempts'] + 1);
        if (isset($data['attempts']) && $data['attempts'] >= 2) {
            $this->repository->updateBlockTime($time, $ip);
            $this->authLog->error(
                '',
                [
                    'ip' => $ip,
                    'email' => $email,
                    'blockStart' => $time,
                    'blockEnd' => $endTime,
                    'path' => 'authLogs.log',
                ]
            );

            return;
        }
    }

    public function checkBlockTime()
    {
        $blocked = false;
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = $this->repository->getLoginAttemptsData($ip);
        if (isset($data['blockTime'])) {
            $blockTime = $data['blockTime'];
            $diff = ((time() - strtotime($blockTime)) / 60);
            if ($diff >= self::BLOCKTIME) {
                $blocked = false;
                $this->repository->clearBlockTime($ip);
                $this->repository->setLoginAttemptsData($ip, 0);
            } else {
                $blocked = true;
            }
        }

        return $blocked;
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
        if (!isset($post['email'])) {
            return;
        }
        $this->user->setData($post);
        $this->checkLoginData($this->user, $post['email'], $post['password']);
        $this->user->loginValidation();
        if (true === $this->user->checkErrors()) {
            $this->repository->setLoginAttemptsData($_SERVER['REMOTE_ADDR'], 0);
            $currentUser = $this->repository->getUserByEmail($post['email']);
            isset($post['remember']) ? $this->setCookie($currentUser) : $this->setSession($currentUser);
        } else {
            $errors = $this->user->error;
            $this->incrementLoginAttempts($post['email']);
        }

        return $errors;
    }

    public function registrationAction($post)
    {
        $errors = null;
        if (!isset($post['email'])) {
            return;
        }
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
            $this->fileLog->info(
                '',
                [
                    'fileName' => $file['name'],
                    'fileSize' => $file['size'],
                    'path' => 'fileLogs.log',
                    'status' => 'Info: File successfully added',
                ]
            );
            $success = 'Successfully updated';
        } else {
            $error = $fileInfo['error'];
            $this->fileLog->error(
                '',
                [
                    'fileName' => $file['name'],
                    'fileSize' => $file['size'],
                    'path' => 'fileLogs.log',
                    'status' => $error,
                ]
            );
        }

        return [
            'error' => $error,
            'success' => $success,
        ];
    }

    public function deleteFileFromDashboard($path)
    {
        if (isset($path)) {
            $this->repository->deleteFile($path);
            $this->fileUploader->deleteFromDir($path);
            $this->fileUploader->deleteEmptyDir($path);
        }
        header('Location: /dashboard/showFiles/'.$_POST['userId']);
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
        setcookie('token', $token, time() + 3600 * 24 * 7, '/');
        $this->repository->addCookie($token, $email);
        header('Location: /dashboard');

        return;
    }

    public function authorization()
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
            if (!empty($possibleUser) && $possibleUser['cookie'] === $_COOKIE['token']) {
                $cookieStatus = true;
                $currentUser = $possibleUser;
            } else {
                $cookieStatus = false;
                $currentUser = false;
            }
        }

        return [
            'cookieStatus' => $cookieStatus,
            'user' => $currentUser,
        ];
    }

    public function logOut()
    {
        setcookie('token', '', time(), '/');
        unset($_SESSION);
        session_destroy();
        header('Location: /login/index');
    }
}
