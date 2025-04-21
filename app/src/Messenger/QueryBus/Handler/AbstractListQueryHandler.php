<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Messenger\QueryBus\Query\QueryListInterface;
use App\Messenger\QueryBus\QueryBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

abstract class AbstractListQueryHandler
{
    protected QueryBuilder $queryBuilder;
    protected QueryListInterface $query;

    public function __construct(
        protected readonly QueryBusInterface $queryBus,
        protected readonly PaginatorInterface $paginator,
        protected readonly EntityManagerInterface $em
    ) {}

    protected function createQueryBuilder(): void
    {
        $this->queryBuilder = $this->em
            ->getRepository($this->query->getEntityClass())
            ->createQueryBuilder($this->query->getAlias());
    }


    protected function filterQuery(): void
    {
        $field = $this->query->getRequest()->query->getString('filterField') ?? null;
        $val = $this->query->getRequest()->query->getString('filterValue') ?? null;

        if ($field && $val) {
            $this->queryBuilder->where("{$field} LIKE :val")
                ->setParameter('val', '%' . $val . '%');
        }
    }

    protected function sortQuery(): void
    {
        $this->queryBuilder->orderBy(
            $this->query->getAlias() . '.' . $this->query->getSortField(),
            $this->query->getRequest()->query->getString('sort', 'asc')
        );
    }

    protected function paginateQuery(): PaginationInterface
    {
        return $this->paginator->paginate(
            //NOTE: paginating array, because when paginating Query, knp paginator
            // will not filter properly (LIKE gives only exact matches)
            $this->queryBuilder->getQuery()->getResult(),
            $this->query->getRequest()->query->getInt('page', 1),
            $this->query->getRequest()->query->getInt('limit', 6)
        );
    }
}
