<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Messenger\CommandBus\CommandBusInterface;
use App\Messenger\QueryBus\QueryBusInterface;
use App\Service\Synchronizer\SynchronizerInterface;

abstract class AbstractSynchronizer implements SynchronizerInterface
{
    public static string $type = '';

    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly QueryBusInterface $queryBus,
    ) {}

    public function supports(string $type): bool
    {
        return $type === static::$type;
    }
}
