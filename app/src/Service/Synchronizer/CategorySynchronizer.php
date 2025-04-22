<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Entity\Category;
use App\Infrastructure\MealDb\Query\CategoriesQuery;
use App\Messenger\CommandBus\Command\SynchronizeEntities;
use App\Messenger\QueryBus\Query\NewEntitiesToSynchronize;

class CategorySynchronizer extends AbstractSynchronizer
{
    public static string $type = 'categories';

    public function synchronize(): void
    {
        $this->commandBus->dispatch(
            new SynchronizeEntities(
                dtos: $this->queryBus->query(
                    new NewEntitiesToSynchronize(
                        entityClass: Category::class,
                        alias: 'c',
                        apiQueryClass: CategoriesQuery::class,
                        syncColumn: 'name'
                    )
                ),
                entityClass: Category::class
            ),
        );
    }
}
