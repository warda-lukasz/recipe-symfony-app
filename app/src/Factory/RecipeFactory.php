<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\RecipeDTO;
use App\Entity\Measurement;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;

class RecipeFactory
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly IngredientRepository $ingredientRepository,
    ) {}

    public function createFromDto(RecipeDto $dto): Recipe
    {
        $recipe = new Recipe();

        $this->buildBasicProperties($dto, $recipe);
        $this->attachCategory($dto, $recipe);
        $this->attachMeasurements($dto, $recipe);

        return $recipe;
    }

    private function buildBasicProperties(RecipeDTO $dto, Recipe $recipe): void
    {
        $recipe
            ->setExternalId($dto->externalId)
            ->setTitle($dto->title)
            ->setArea($dto->area)
            ->setInstructions($dto->instructions)
            ->setMealThumb($dto->thumb)
            ->setTags($dto->tags)
            ->setYoutube($dto->yt)
            ->setSource($dto->source)
        ;
    }

    private function attachCategory(RecipeDTO $dto, Recipe $recipe): void
    {
        $category = $this->categoryRepository->findOneBy(['name' => $dto->category]);

        if ($category) {
            $recipe->setCategory($category);
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

            $measurement = (new Measurement())
                ->setIngredient($ingredient)
                ->setRecipe($recipe)
                ->setMeasure($dto->measurements[$key]);

            $ingredient->addMeasurement($measurement);
            $recipe->addMeasurement($measurement);
        }
    }
}
