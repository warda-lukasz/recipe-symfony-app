<?php
declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

interface QueryInterface
{
    public function getEntityClass(): string;

    public function getAlias(): string;
}
