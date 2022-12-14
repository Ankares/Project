<?php

namespace  App\Logs;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        file_put_contents(__DIR__.'/'.$context['path'], "[$level]: $message", FILE_APPEND);
    }
}
