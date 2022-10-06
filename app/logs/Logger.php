<?php

namespace  App\Logs;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    private $file = '';
    private $status = '';
    
    public function log($level, \Stringable|string $message, array $context = []): void {
        $day = date('Y-m-d H:i:s');
        $fileName = $context[0]['name'];
        $fileSize = $context[0]['size'];
        $status = $context[1];
        $message = "$day, fileName: $fileName, fileSize: $fileSize, status: $status";
        file_put_contents(__DIR__."/"."fileLogs.log",  "[$level]: $message");
    }
}