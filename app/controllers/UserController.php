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
            $this->repository->checkUser($this->user, $_POST['email']);
            $this->user->validation();
            if (empty($this->user->error)) {
                $this->repository->add($this->user);
                $data['success'] = 'User successfully added';
            } else {
                $data['error'] = $this->user->error;
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
            $fileObj = $this->file->service($_FILES['file']);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['id']);
            $this->user->validation();
            if (empty($this->user->error) && empty($fileObj->error)) {
                $this->repository->updateUser($this->user, $_POST['id']);   
                if($fileObj->file != '') {
                    $pathForDB = $fileObj->moveFile($_FILES['file'], $fileObj->uniqName);
                    $this->repository->addFile($_POST['id'], $fileObj->file, $pathForDB, $fileObj->size);
                }
                $data['success'] = 'Successfully updated';
            } else {
                $data['error'] = [$this->user->error, $fileObj->error];
            }            
        }
        $data['user'] = $this->repository->getDataByID($id);
        $data['files'] = $this->repository->getUserFiles($id);
        $this->view('user/edit', $data);
    }

    public function editFiles($id)
    {
        $data = null;
        $data['user'] = $this->repository->getDataByID($id);
        $data['files'] = $this->repository->getUserFiles($id);
        $this->view('user/editFiles', $data);
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $this->repository->deleteByID($_POST['delete']);
        }
        header('Location: /user/list');
    }

    public function deleteFiles()
    {
        if (isset($_POST['imageToDelete'])) {
            $this->repository->deleteFileById($_POST['imageToDelete']);
        }
        header('Location: /user/editFiles/'.$_POST['idToDelete']);       
    }
}