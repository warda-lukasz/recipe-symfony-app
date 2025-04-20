<?php

declare(strict_types=1);

namespace App\Infrastructure\MealDb\Client;

use App\Infrastructure\MealDb\Query\MealDbQueryInterface;

interface MealDbClientInterface
{
    public function execute(MealDbQueryInterface $query): array;
    public static function getIngrendientImageUrl(string $ingredientName): string;
}
