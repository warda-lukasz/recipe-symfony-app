<?php

namespace App\Infrastructure\MealDb\Query;

use App\Dto\IngredientDTO;

class IngredientsQuery implements MealDbQueryInterface
{
    public function getEndpoint(): string
    {
        return 'list.php?i=list';
    }

    /**
     * @return array<array<string>>
     */
    public function parseResponse(array $responseData): array
    {
        $ingredients = [];

        foreach ($responseData['meals'] as $ingredientData) {
            $ingredients[] = IngredientDTO::fromArray($ingredientData);
        }

        return $ingredients;
    }
}
