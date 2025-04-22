<?php

declare(strict_types=1);

namespace App\Infrastructure\MealDb\Query;

use App\Dto\MealByCategoryDTO;
use App\Infrastructure\MealDb\Query\MealDbQueryInterface;

class MealsByCategoryQuery implements MealDbQueryInterface
{
    public function __construct(
        private readonly string $category,
    ) {}

    public function getEndpoint(): string
    {
        return sprintf('filter.php?c=%s', $this->category);
    }

    /**
     * @return MealByCategoryDTO[]
     */
    public function parseResponse(array $responseData): array
    {
        $meals = [];

        foreach ($responseData['meals'] as $mealData) {
            $meals[] = MealByCategoryDTO::fromArray($mealData);
        }

        return $meals;
    }
}
