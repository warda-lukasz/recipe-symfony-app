<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Entity\Ingredient;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Messenger\QueryBus\Query\IngredientImageUrlQuery;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class IngredientImageUrlQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly MealDbClientInterface $mealDbClient,
        private readonly QueryBusInterface $queryBus,
    ) {}

    public function __invoke(IngredientImageUrlQuery $query): string
    {
        return $this->mealDbClient::getIngrendientImageUrl(
            $this->queryBus->query(new ShowQuery($query->getId(), Ingredient::class, 'i'))->getName()
        );
    }
}
