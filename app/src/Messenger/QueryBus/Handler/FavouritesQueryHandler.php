<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Dto\FavouritesDTO;
use App\Messenger\QueryBus\Query\FavouritesQuery;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FavouritesQueryHandler extends AbstractListQueryHandler
{

    private FavouritesDTO $dto;

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
            ->andWhere($this->query->getAlias() . '.id IN (:favs)')
            ->setParameter('favs', $this->dto->favourites);
    }
}
