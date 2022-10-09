<?php

namespace App\Events;

class FileUploadEvent
{

    private function fileProccessing($file) {

        $explodedName = explode('.', $file['name']);
        $newInuqName = uniqid($explodedName[0]) . '.' . $explodedName[1];
        $firstDir = strtolower(substr($newInuqName, 0, 2));
        $secDir = strtolower(substr($newInuqName, 2, 2));
        $fileSaveDir = __DIR__ . '/../../public/userFiles/'.$firstDir.'/'.$secDir;
        $pathForDB = $firstDir . '/' . $secDir . '/' . $newInuqName; 

        return [
            'uniqName' => $newInuqName,
            'saveDir' => $fileSaveDir,
            'pathForDB' => $pathForDB
        ];
    }

    public function checkFile($file)
    {
        $correctExtensions = ['image/jpeg', 'image/png', 'text/plain', 'application/msword'];
        $maxsize = 2048000;
        $error = '';

        if($file['name'] != '') {
            if($file['size'] >= $maxsize || $file['size'] == 0) {
                $error = 'Warning: Size should be less then 2mb';
            }   
        } 
        if($file['tmp_name'] != '') {
            $ext = @mime_content_type($file['tmp_name']);
            if(!in_array($ext, $correctExtensions)) {
                $error = 'Warning: Unsupported extension';
            } 
        }
        
        return [
            'error' => $error,
            'fileName' => $file['name'],
            'fileSize' => $file['size']
        ];
    }

    public function moveFile($fileName) {

        $fileInfo = $this->fileProccessing($fileName);

        try {
            @mkdir($fileInfo['saveDir'], 0777, true);
        }
        finally {
            move_uploaded_file($fileName['tmp_name'], $fileInfo['saveDir'].'/'.$fileInfo['uniqName']);
        }

        return $fileInfo['pathForDB'];
    }

    public function deleteFromDir($filePath) {
        if($filePath != '') {
            unlink(__DIR__.'/../../public/userFiles/'.$filePath);   
        }
    }

    public function deleteEmptyDir($filePath) {
            $path = explode('/', $filePath);
            $firstDir = $path[0];
            $secondDir = $path[1];
            if(isset($firstDir) && isset($secondDir)) {
                @rmdir(__DIR__.'/../../public/userFiles/'.$firstDir.'/'.$secondDir);
                @rmdir(__DIR__.'/../../public/userFiles/'.$firstDir);
            }
    }
}