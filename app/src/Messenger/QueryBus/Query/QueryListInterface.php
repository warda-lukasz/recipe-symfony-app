<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

use Symfony\Component\HttpFoundation\Request;

interface QueryListInterface extends QueryInterface
{
    public function getRequest(): Request;
    public function getSortField(): string;
}
