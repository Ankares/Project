<?php

namespace App\Events;

class FileUploadEvent
{
    public function __construct(
        public $error = [],
        public $file = [],
        public $size = []
    ) {}

    public function fileProccessing($file) {

        $explodedName = explode('.', $file['name']);
        $newInuqName = uniqid($explodedName[0]) . '.' . $explodedName[1];
        $firstDir = strtolower(substr($newInuqName, 0, 2));
        $secDir = strtolower(substr($newInuqName, 2, 2));
        $fileSaveDir = __DIR__ . '/../../public/userFiles/'.$firstDir.'/'.$secDir;
        $pathForDB = $firstDir . '/' . $secDir . '/' . $newInuqName; 

        return [
            'uniqName' => $newInuqName,
            'firstDir' => $firstDir,
            'secondDir' => $secDir,
            'saveDir' => $fileSaveDir,
            'pathForDB' => $pathForDB
        ];
    }

    public function service($file)
    {
        $correctExtensions = ['image/jpeg', 'image/png', 'text/plain'];
        $maxsize = 2048000;
        $error = '';

        if($file['name'] != '') {
            if($file['tmp_name'] != '') {
                $ext = @mime_content_type($file['tmp_name']);
                if(!in_array($ext, $correctExtensions)) {
                    $error = 'Warning: Unsupported extension';
                } 
            }
            if($file['size'] >= $maxsize || $file['size'] == 0) {
                $error = 'Warning: Size should be less then 2mb';
            }
        } 
        
        return new FileUploadEvent(
            $error,
            $file['name'],
            $file['size']
        );
    }

    public function moveFile($fileName) {

        $fileInfo = $this->fileProccessing($fileName);
        if(is_dir($fileInfo['saveDir'])) {
            move_uploaded_file($fileName['tmp_name'], $fileInfo['saveDir'].'/'.$fileInfo['uniqName']);
        }
        else {
            mkdir($fileInfo['saveDir'], 0777, true);
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
            @rmdir(__DIR__.'/../../public/userFiles/'.$firstDir.'/'.$secondDir);
            @rmdir(__DIR__.'/../../public/userFiles/'.$firstDir);
    }
}