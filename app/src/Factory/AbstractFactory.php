<?php

declare(strict_types=1);

namespace App\Factory;

use App\Messenger\QueryBus\QueryBusInterface;

abstract class AbstractFactory implements FactoryInterface
{
    public function __construct(
        protected QueryBusInterface $queryBus
    ) {}
}
