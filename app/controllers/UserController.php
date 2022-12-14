<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Repositories\UserRepository;
use App\Models\UserModel;
use App\Services\FileUpload;
use App\Logs\LoggingFiles;

class UserController extends Controller
{
    public function __construct(
        private readonly UserModel $user,
        private readonly UserRepository $repository,
        private readonly FileUpload $fileUploader,
        private readonly LoggingFiles $fileLog
    ) {
    }

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
            $fileInfo = $this->fileUploader->checkFile($_FILES['file']);
            $this->repository->checkUser($this->user, $_POST['email'], $_POST['id']);
            $this->user->validation();
            if (empty($this->user->error) && empty($fileInfo['error'])) {
                $this->repository->updateUser($this->user, $_POST['id']);
                if ($fileInfo['fileName'] != '') {
                    $pathForDB = $this->fileUploader->moveFile($_FILES['file']);
                    $this->repository->addFile($_POST['id'], $fileInfo['fileName'], $pathForDB, $fileInfo['fileSize']);
                    $this->fileLog->info('', ['fileName' => $_FILES['file']['name'], 'fileSize' => $_FILES['file']['size'], 'path' => 'fileLogs.log', 'status' => 'Info: File successfully added']);
                }
                $data['success'] = 'Successfully updated';
            } else {
                $data['error'] = [$this->user->error, $fileInfo['error']];
                $this->fileLog->error('', ['fileName' => $_FILES['file']['name'], 'fileSize' => $_FILES['file']['size'], 'path' => 'fileLogs.log', 'status' => $fileInfo['error']]);
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
        if (isset($_POST['pathToDelete'])) {
            $this->repository->deleteFileById($_POST['pathToDelete']);
            $this->fileUploader->deleteFromDir($_POST['pathToDelete']);
            $this->fileUploader->deleteEmptyDir($_POST['pathToDelete']);
        }

        header('Location: /user/editFiles/'.$_POST['userId']);
    }
}
