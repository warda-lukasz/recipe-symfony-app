<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Messenger\QueryBus\Query\ShowQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ShowQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    public function __invoke(ShowQuery $query): mixed
    {
        return $this->em->getRepository($query->getEntityClass())
            ->find($query->getId());
    }
}
