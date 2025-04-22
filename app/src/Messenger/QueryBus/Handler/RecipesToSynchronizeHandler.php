<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Dto\MealByCategoryDTO;
use App\Entity\Recipe;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Infrastructure\MealDb\Query\MealsByCategoryQuery;
use App\Infrastructure\MealDb\Query\RecipeDetailsQuery;
use App\Messenger\QueryBus\Query\RecipesToSynchronize;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RecipesToSynchronizeHandler
{
    public function __construct(
        private CategoryRepository $categoryRepo,
        private MealDbClientInterface $client,
        private EntityManagerInterface $em,
        private int $limiter = 0,
    ) {}
    public function __invoke(RecipesToSynchronize $query): array
    {
        return $this->fetchNewRecipes();
    }

    private function fetchNewRecipes(): array
    {
        $newRecipes = $this->filterNewRecipes();
        $recipes = [];

        foreach ($newRecipes as $externalId) {
            $recipe = $this->client->execute(
                new RecipeDetailsQuery($externalId)
            );

            $this->rateLimiter();

            $recipes = array_merge(
                $recipes,
                $recipe
            );
        }

        return $recipes;
    }


    /**
     * HACK: Unfortunately, we cannot pull from the API at full speed,
     * because we hit the rate limit. Therefore, every 20 elements 
     * we'll give the server a little break.
     * 1 second should be enough, with shorter times I got HTTP 429
     */
    private function rateLimiter(): void
    {
        if ($this->limiter >= 20) {
            sleep(1);
            $this->limiter = 0;
        }

        $this->limiter++;
    }

    private function filterNewRecipes(): array
    {
        $dtosExIds = array_map(function (MealByCategoryDTO $dto) {
            return $dto->externalId;
        }, $this->fetchRecipesByCategory());

        $exIds = $this->em->getRepository(Recipe::class)
            ->findAllExternalIds();

        return array_diff($dtosExIds, $exIds);
    }

    /**
     * @return RecipeDTO[]
     */
    private function fetchRecipesByCategory(): array
    {
        $categories = $this->categoryRepo->findAllCategoryNames();
        $apiEntities = [];

        foreach ($categories as $category) {
            $apiEntities = array_merge(
                $apiEntities,
                $this->client->execute(
                    new MealsByCategoryQuery($category)
                )
            );
        }

        return $apiEntities;
    }
}
