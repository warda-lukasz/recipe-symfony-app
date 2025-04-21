<?php

declare(strict_types=1);

namespace App\Messenger\Scheduler\Handler;

use App\Messenger\Scheduler\Message\SyncMealDb;
use App\Service\LoggingService;
use App\Service\MealDbSynchronizer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler()]
class SyncMealDbHandler
{
    public function __construct(
        private MealDbSynchronizer $synchronizer,
        private LoggingService $logger
    ) {}

    public function __invoke(SyncMealDb $msg): void
    {
        try {
            $this->logger->startProcess('MealDB Synchronization');
            $this->synchronizer->synchronize();
            $this->logger->endProcess();

        } catch (Throwable $e) {
            $this->logger->logException($e, 'Error occurred during MealDB synchronization');
        }
    }
}
