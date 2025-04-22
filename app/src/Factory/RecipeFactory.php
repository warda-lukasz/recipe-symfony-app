<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\DtoInterface;
use App\Dto\MeasurementDTO;
use App\Dto\RecipeDTO;
use App\Entity\EntityInterface;
use App\Entity\Measurement;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use InvalidArgumentException;

class RecipeFactory extends AbstractFactory
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly IngredientRepository $ingredientRepository,
    ) {}

    public function create(DtoInterface $dto, string $entityClass = Recipe::class, string $dtoClass = RecipeDTO::class): EntityInterface
    {
        if (!$dto instanceof $dtoClass) {
            throw new InvalidArgumentException('Invalid DTO type');
        }

        $recipe = new Recipe($dto);

        $this->attachCategory($dto, $recipe);
        $this->attachMeasurements($dto, $recipe);

        return $recipe;
    }

    private function attachCategory(RecipeDTO $dto, Recipe $recipe): void
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy(['name' => $dto->category]);

        if ($category) {
            $category->addRecipe($recipe);
        }
    }

    private function attachMeasurements(RecipeDTO $dto, Recipe $recipe): void
    {
        foreach ($dto->ingredients as $key => $name) {

            if (empty($name)) {
                continue;
            }

            /** @var Ingredient $ingredient */
            $ingredient = $this->ingredientRepository->findOneBy(['name' => $name]);

            if (!$ingredient) {
                //INFO: I'll skip this here to avoid going into details.
                // But we could create a new Ingredient, or search among
                // already synchronized ones using LIKE, because they may differ in recipes
                continue;
            }

            $measurementDTO = new MeasurementDTO($ingredient, $recipe);

            $measurement = (new Measurement($measurementDTO))
                ->setMeasure($dto->measurements[$key]);

            $ingredient->addMeasurement($measurement);
            $recipe->addMeasurement($measurement);
        }
    }
}
