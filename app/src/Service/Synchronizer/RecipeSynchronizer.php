<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Dto\MealByCategoryDTO;
use App\Dto\RecipeDTO;
use App\Factory\RecipeFactory;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Infrastructure\MealDb\Query\MealsByCategoryQuery;
use App\Infrastructure\MealDb\Query\RecipeDetailsQuery;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;

class RecipeSynchronizer extends AbstractSynchronizer
{
    public static string $type = 'recipes';

    public function __construct(
        private readonly RecipeRepository $recipeRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly MealDbClientInterface $mealDbClient,
        private readonly RecipeFactory $recipeFactory,
        private array $existingIds = [],
        private array $categories = [],
        private int $limiter = 0,
    ) {
        $this->existingIds = $this->recipeRepository->findAllExternalIds();
        $this->categories = $this->categoryRepository->findAllCategoryNames();
    }

    public function synchronize(): void
    {
        $newRecipes = $this->filterNewRecipes();

        if (empty($newRecipes)) {
            return;
        }

        /** @var MealByCategoryDTO $mealByCategoryDto */
        foreach ($newRecipes as $mealByCategoryDto) {


            $dto = $this->fetchRecipeDetails($mealByCategoryDto->externalId);
            $recipe = $this->recipeFactory->createFromDto($dto);

            $this->recipeRepository->save($recipe, false);
            $this->sanityCheck();
        }

        $this->recipeRepository->flush();
    }

    /**
     * HACK: Unfortunately, we cannot pull from the API at full speed,
     * because we hit the rate limit.
     * Therefore, every 25 elements we'll give the server a little break.
     * 1 second should be enough, with shorter times I got HTTP 429
     *
     * We'll also clear the entity manager's memory while we're at it.
     */
    private function sanityCheck(): void
    {
        if ($this->limiter >= 25) {
            $this->recipeRepository->flush();
            $this->recipeRepository->clear();
            sleep(1);
            $this->limiter = 0;
        }

        $this->limiter++;
    }

    private function filterNewRecipes(): array
    {
        $dtos = $this->fetchRecipesByCategory();

        return array_filter($dtos, function (MealByCategoryDTO $dto) {
            return !in_array($dto->externalId, $this->existingIds);
        });
    }

    /**
     * @return RecipeDTO[]
     */
    private function fetchRecipesByCategory(): array
    {
        $recipes = [];

        foreach ($this->categories as $category) {
            $recipes = array_merge(
                $recipes,
                $this->mealDbClient->execute(
                    new MealsByCategoryQuery($category)
                )
            );
        }

        return $recipes;
    }

    private function fetchRecipeDetails(string $externalId): RecipeDTO
    {
        /** @var RecipeDTO[] $res */
        $res = $this->mealDbClient->execute(
            new RecipeDetailsQuery($externalId)
        );

        return $res[0];
    }
}
