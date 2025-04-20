<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Throwable;

class LoggingService
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private string $processName = '',
        private float $start = 0.0,
    ) {}

    public function logException(Throwable $e, string $title = 'Error occurred'): void
    {
        $this->logger->error($title, [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
        ]);
    }

    public function startProcess(string $name): void
    {
        $this->processName = $name;
        $this->start = microtime(true);

        $this->logger->info('Starting process', [
            'name' => $this->processName,
        ]);
    }

    public function endProcess(): void
    {
        $duration = microtime(true) - $this->start;

        $this->logger->info('Process completed', [
            'name' => $this->processName,
            'duration' => round($duration, 3)
        ]);
    }
}
