<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

use App\Dto\FavouritesDTO;
use Symfony\Component\HttpFoundation\Request;

class FavouritesQuery extends AbstractListQuery
{
    public function __construct(
        private FavouritesDTO $dto,
        private Request $request,
        private string $entityClass,
        private string $alias,
        private string $sortField = 'id'
    ) {
        parent::__construct($request, $entityClass, $alias, $sortField);
    }

    public function getDto(): FavouritesDTO
    {
        return $this->dto;
    }
}
