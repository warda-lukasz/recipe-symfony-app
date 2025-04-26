<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Dto\FavouritesDTO;
use App\Messenger\QueryBus\Query\FavouritesQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FavouritesQueryHandler extends AbstractListQueryHandler
{
    public function __construct(
        QueryBusInterface $queryBus,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        private readonly Security $security,
    ) {
        parent::__construct($queryBus, $paginator, $em);
    }

    public function __invoke(FavouritesQuery $query): PaginationInterface
    {
        $this->query = $query;

        $this->createQueryBuilder($query);
        $this->filterQuery();
        $this->sortQuery();

        return $this->paginateQuery();
    }

    protected function filterQuery(): void
    {
        parent::filterQuery();

        $this->queryBuilder
            ->join('r.favourites', 'f', 'WITH', 'r.id = f.recipe')
            ->andWhere('f.username = :username')
            ->andWhere('f.username = :username')
            ->setParameter('username', $this->security->getUser()->getUsername());
    }
}
