<?php

namespace  App\Logs;

class LoggingFiles extends Logger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $day = date('Y-m-d H:i:s');
        $fileName = $context['fileName'];
        $fileSize = $context['fileSize'];
        $status = $context['status'];
        $message = "$day, fileName: $fileName, fileSize: $fileSize, status: $status;";
        parent::log($level, $message, $context);
    }
}
