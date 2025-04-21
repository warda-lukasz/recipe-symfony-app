<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus;

use App\Messenger\QueryBus\Query\QueryInterface;

interface QueryBusInterface
{
    public function query(QueryInterface $query): mixed;
}
