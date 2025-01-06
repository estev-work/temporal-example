<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Logger;

use Modules\Shared\Application\Logger\AppLoggerInterface;
use Psr\Log\LogLevel;

abstract class BaseLogger implements AppLoggerInterface
{
    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $backtrace = debug_backtrace();
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $backtrace = debug_backtrace()[0]['file'] . ':' . debug_backtrace()[0]['line'];
        $context['backtrace'] = $backtrace;
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}
