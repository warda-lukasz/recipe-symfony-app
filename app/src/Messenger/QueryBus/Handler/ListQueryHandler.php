<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Handler;

use App\Messenger\QueryBus\Query\ListQuery;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ListQueryHandler extends AbstractListQueryHandler
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
