<?php

declare(strict_types=1);

namespace App\Infrastructure\MealDb\Query;

use App\Dto\BuildableFromArray;

interface MealDbQueryInterface
{
    public function getEndpoint(): string;
    public function parseResponse(array $responseData): array|BuildableFromArray;
}
