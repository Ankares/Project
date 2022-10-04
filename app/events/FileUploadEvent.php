<?php

namespace App\Events;

class FileUploadEvent
{
    public function __construct(
        public $error = [],
        public $file = [],
        public $size = []
    ) {}

    public function service($file)
    {
        $maxsize = 2048000;
        $currentFile = $file['name'];
        $currentSize = $file['size'];
        $error = '';

        if($currentFile != '') {
            $correctExtensions = ['txt','doc','docx','jpg','jpeg','png'];
            $ext = pathinfo($currentFile, PATHINFO_EXTENSION);
            if(!in_array($ext,$correctExtensions)) {
                $error = 'Files: Unsupported extension';
            } 
            if($currentSize >= $maxsize || $currentSize == 0) {
                $error = 'Files: Size should be less then 2mb';
            }
            if(file_exists( __DIR__ . '/../../public/userFiles/' . $file['name'])) {
                $error = 'Files: This file is already used';
            }
        }
        return new FileUploadEvent(
            $error,
            $currentFile,
            $currentSize
        );
    }
}