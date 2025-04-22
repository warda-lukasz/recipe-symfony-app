<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Factory\ApiQueryFactory;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Messenger\QueryBus\Query\NewEntitiesToSynchronize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NewEntitiesToSynchronizeHandler
{
    public function __construct(
        private readonly MealDbClientInterface $mealDbClient,
        private readonly EntityManagerInterface $em,
        private readonly ApiQueryFactory $apiQueryFactory,
    ) {}

    public function __invoke(NewEntitiesToSynchronize $query): array
    {
        $apiEntities = $this->mealDbClient->execute(
            $this->apiQueryFactory->create($query->getApiQueryClass())
        );

        $entities = $this->em->createQueryBuilder()
            ->select("{$query->getAlias()}.{$query->getSyncColumn()}")
            ->from($query->getEntityClass(), $query->getAlias())
            ->getQuery()
            ->getSingleColumnResult();


        return array_filter($apiEntities, function ($dto) use ($query, $entities) {
            $dtoProperty = $query->getSyncColumn();

            return !in_array($dto->$dtoProperty, $entities);
        });
    }
}
