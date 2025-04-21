<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Messenger\QueryBus\Query\QueryInterface;
use App\Messenger\QueryBus\Query\ListQuery;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use InvalidArgumentException;

#[AsMessageHandler]
final class RecipesQueryHandler extends AbstractListQueryHandler
{
    public function __invoke(ListQuery $query): PaginationInterface
    {
        $this->query = $query;
        $this->createQueryBuilder($query);
        $this->filterQuery();
        $this->sortQuery();

        return $this->paginateQuery();
    }
}
