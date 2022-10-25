<?php

namespace  App\Logs;

class LoggingAuth extends Logger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $userIp = $context['ip'];
        $userEmail = $context['email'];
        $blockStartPeriod = $context['blockStart'];
        $blockEndPeriod = $context['blockEnd'];
        $message = "ip: $userIp, email: $userEmail, blocked: $blockStartPeriod, endBlock: $blockEndPeriod.";
        parent::log($level, $message, $context);
    }
}
