<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

use App\Dto\FavouritesDTO;
use Symfony\Component\HttpFoundation\Request;

class FavouritesQuery extends AbstractListQuery
{
    public function __construct(
        private FavouritesDTO $dto,
        protected Request $request,
        protected ?string $entityClass = null,
        protected ?string $alias = null,
        protected string $sortField = 'id'
    ) {
        parent::__construct(
            request: $request,
            entityClass: $entityClass,
            alias: $alias,
            sortField: $sortField
        );
    }

    public function getDto(): FavouritesDTO
    {
        return $this->dto;
    }
}
