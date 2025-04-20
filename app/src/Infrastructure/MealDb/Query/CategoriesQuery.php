<?php

namespace App\Infrastructure\MealDb\Query;

use App\Dto\CategoryDTO;

class CategoriesQuery implements MealDbQueryInterface
{
    public function getEndpoint(): string
    {
        return 'categories.php';
    }

    /**
     * @return array<CategoryDTO>
     */
    public function parseResponse(array $responseData): array
    {
        $categories = [];

        foreach ($responseData['categories'] as $categoryData) {
            $categories[] = CategoryDTO::fromArray($categoryData);
        }

        return $categories;
    }
}
