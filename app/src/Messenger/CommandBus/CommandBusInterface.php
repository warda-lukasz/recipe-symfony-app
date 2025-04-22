<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus;

use App\Messenger\CommandBus\Command\CommandInterface;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $query): mixed;
}
