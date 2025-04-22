<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Messenger\QueryBus\Query\EntitiesFieldAsArrayQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EntitiesFieldAsArrayQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(EntitiesFieldAsArrayQuery $query): array
    {
        $repository = $this->entityManager->getRepository($query->getEntityClass());
        return $repository->createQueryBuilder($query->getAlias())
            ->select("{$query->getAlias()}.{$query->getField()}")
            ->getQuery()
            ->getSingleColumnResult();
    }
}
