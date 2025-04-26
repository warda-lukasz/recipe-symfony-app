<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Dto\FavouritesDTO;
use App\Messenger\QueryBus\Query\FavouritesQuery;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FavouritesQueryHandler extends AbstractListQueryHandler
{

    private FavouritesDTO $dto;

    public function __construct(
        private readonly Security $security,
    ) {}


    public function __invoke(FavouritesQuery $query): PaginationInterface
    {
        $this->query = $query;
        $this->dto = $query->getDto();

        $this->createQueryBuilder($query);
        $this->filterQuery();
        $this->sortQuery();

        return $this->paginateQuery();
    }

    protected function filterQuery(): void
    {
        parent::filterQuery();

        $this->queryBuilder
            ->join('r.favourites', 'f', 'WITH')
            ->andWhere('f.username = :username')
            ->setParameter('username', $this->security->getUser()->getUsername());
    }
}
