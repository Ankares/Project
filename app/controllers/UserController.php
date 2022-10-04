<?php

namespace App\Controllers;
use App\Models;
use App\Core\Controller;
use App\Core\ServiceProvider;
use App\Models\Repositories\IUserProcessing;
use App\Models\Repositories\UserRepository;
use App\Models\UserModel;
use App\Events\FileUploadEvent;

class UserController extends Controller
{

    public function __construct(
        private UserModel $user,
        private UserRepository $repository,
        private FileUploadEvent $file
    ) {}

    public function index() 
    {
        $data = null;
        if (isset($_POST['email'])) {
            $this->user->setData($_POST);
            $fileObj = $this->file->service($_FILES['file']);
            $this->repository->checkUser($this->user, $_POST['email']);
            $this->user->validation();
            if (empty($this->user->error) && empty($fileObj->error)) {
                $this->repository->add($this->user, $fileObj->file, $fileObj->size);
                move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '/../../public/userFiles/' . $_FILES['file']['name']);
                $data['success'] = 'User successfully added';
            } else {
                $data['error'] = [$this->user->error, $fileObj->error];
            }
        }
        $this->view('user/index', $data);
    }

    public function list()
    {
        $data = null;
        $data['users'] = $this->repository->getAllData();
        $this->view('user/list', $data);
    }

    public function edit($id)
    {
        $data = null;
        if (isset($_POST['id'])) {
            $this->user->setData($_POST);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['id']);
            $this->user->validation();
            if (empty($this->user->error)) {
                $this->repository->updateUser($this->user, $_POST['id']);   
                $data['success'] = 'Successfully updated';
            } else {
                $data['error'] = $this->user->error;
            }            
        }
        $data['user'] = $this->repository->getDataByID($id);
        $this->view('user/edit', $data);
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $this->repository->deleteByID($_POST['delete']);
        }
        header('Location: /user/list');
    }
}