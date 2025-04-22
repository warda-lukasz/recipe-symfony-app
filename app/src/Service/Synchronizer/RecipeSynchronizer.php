<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Entity\Recipe;
use App\Infrastructure\MealDb\Query\MealsByCategoryQuery;
use App\Messenger\CommandBus\Command\SynchronizeRecipes;
use App\Messenger\QueryBus\Query\RecipesToSynchronize;

class RecipeSynchronizer extends AbstractSynchronizer
{
    public static string $type = 'recipes';

    public function synchronize(): void
    {
        $this->commandBus->dispatch(
            new SynchronizeRecipes(
                dtos: $this->queryBus->query(
                    new RecipesToSynchronize(
                        entityClass: Recipe::class,
                        alias: 'r',
                        apiQueryClass: MealsByCategoryQuery::class,
                    )
                ),
                entityClass: Recipe::class
            ),
        );
    }
}
