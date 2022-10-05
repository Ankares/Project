<?php

namespace App\Events;

class FileUploadEvent
{
    public function __construct(
        public $error = [],
        public $file = [],
        public $uniqName = [],
        public $size = []
    ) {}

    public function service($file)
    {
        $maxsize = 2048000;
        $currentSize = $file['size'];
        $newInuqName = '';
        $error = '';

        if($file['name'] != '') {
            $explodedName = explode('.', $file['name']);
            $newInuqName = uniqid($explodedName[0]) . '.' . $explodedName[1];
            if($file['tmp_name'] != '') {
                $ext = @mime_content_type($file['tmp_name']);
                if($ext != 'image/jpeg' && $ext != 'image/png' && $ext != 'text/plain') {
                    $error = 'Files: Unsupported extension';
                } 
            }
            if($currentSize >= $maxsize || $currentSize == 0) {
                $error = 'Files: Size should be less then 2mb';
            }
        } 
        return new FileUploadEvent(
            $error,
            $file['name'],
            $newInuqName,
            $currentSize
        );
    }

    public function moveFile($fileName, $uniqFileName) {

        $pathForDB = '';
        $firstDir = strtolower(substr($uniqFileName, 0, 2));
        $secDir = strtolower(substr($uniqFileName, 2, 2));
        $fileSaveDir = __DIR__ . '/../../public/userFiles/'.$firstDir.'/'.$secDir;
        if(is_dir($fileSaveDir)) {
            move_uploaded_file($fileName['tmp_name'], $fileSaveDir.'/'.$uniqFileName);
        }
        else {
            mkdir($fileSaveDir, 0777, true);
            move_uploaded_file($fileName['tmp_name'], $fileSaveDir.'/'.$uniqFileName);
        }
        
        $pathForDB = $firstDir . '/' . $secDir . '/' . $uniqFileName; 
        return $pathForDB;
       
    }
}