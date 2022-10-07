<?php

namespace  App\Logs;

class LoggerProccessing 
{
    public static function logProccess($data) {
        $day = date('Y-m-d H:i:s');
        $fileName = $data[0]['name'];
        $fileSize = $data[0]['size'];
        $status = $data[1];
        $message = "$day, fileName: $fileName, fileSize: $fileSize, status: $status;";
        return $message;
    }
}