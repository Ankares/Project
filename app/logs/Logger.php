<?php

namespace  App\Logs;
use Psr\Log\AbstractLogger;
use App\Logs\LoggerProccessing;

class Logger extends AbstractLogger
{
    public function log($level, \Stringable|string $message, array $context = []): void {
        $message = LoggerProccessing::logProccess($context);
        file_put_contents(__DIR__."/"."fileLogs.log",  "[$level]: $message", FILE_APPEND);
    }
}