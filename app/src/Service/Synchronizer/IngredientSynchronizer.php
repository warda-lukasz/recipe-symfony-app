<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Dto\IngredientDTO;
use App\Entity\Ingredient;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Infrastructure\MealDb\Query\IngredientsQuery;
use App\Repository\IngredientRepository;

class IngredientSynchronizer extends AbstractSynchronizer
{
    public static string $type = 'ingredients';

    public function __construct(
        private readonly IngredientRepository $ingredientRepository,
        private readonly MealDbClientInterface $mealDbClient,
        private array $externalIds = [],
    ) {
        $this->externalIds = $this->ingredientRepository->findAllExternalIds();
    }

    public function synchronize(): void
    {
        $newIngredients = $this->filterNewIngredients();

        if (empty($newIngredients)) {
            return;
        }

        /** @var IngredientDTO $ingredient */
        foreach ($newIngredients as $ingredient) {
            $this->ingredientRepository->save(
                Ingredient::fromDto($ingredient),
                false
            );
        }

        $this->ingredientRepository->flush();
    }

    private function fetchIngredients(): array
    {
        return $this->mealDbClient->execute(new IngredientsQuery());
    }

    private function filterNewIngredients(): array
    {
        $dtos = $this->fetchIngredients();

        return array_filter($dtos, function (IngredientDTO $dto) {
            return !in_array($dto->externalId, $this->externalIds);
        });
    }
}
