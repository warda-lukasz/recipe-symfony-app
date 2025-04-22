<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Entity\Ingredient;
use App\Infrastructure\MealDb\Query\IngredientsQuery;
use App\Messenger\CommandBus\Command\SynchronizeEntities;
use App\Messenger\QueryBus\Query\NewEntitiesToSynchronize;

class IngredientSynchronizer extends AbstractSynchronizer
{
    public static string $type = 'ingredients';

    public function synchronize(): void
    {
        $this->commandBus->dispatch(
            new SynchronizeEntities(
                dtos: $this->queryBus->query(
                    new NewEntitiesToSynchronize(
                        entityClass: Ingredient::class,
                        alias: 'c',
                        apiQueryClass: IngredientsQuery::class,
                    )
                ),
                entityClass: Ingredient::class
            ),
        );
    }
}
