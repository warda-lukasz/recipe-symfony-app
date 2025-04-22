<?php

declare(strict_types=1);

namespace App\Factory;

use App\Infrastructure\MealDb\Query\MealDbQueryInterface;
use InvalidArgumentException;

class ApiQueryFactory
{
    public function create(string $queryClassName): MealDbQueryInterface
    {
        if (!is_subclass_of($queryClassName, MealDbQueryInterface::class)) {
            throw new InvalidArgumentException('Invalid query class type');
        }

        return new $queryClassName();
    }
}
