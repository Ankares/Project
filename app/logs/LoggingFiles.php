<?php

namespace  App\Logs;

class LoggingFiles extends Logger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $day = date('Y-m-d H:i:s');
        $fileName = $context[0]['name'];
        $fileSize = $context[0]['size'];
        $status = $context[1];
        $message = "$day, fileName: $fileName, fileSize: $fileSize, status: $status;";
        parent::log($level, $message, $context);
    }
}
