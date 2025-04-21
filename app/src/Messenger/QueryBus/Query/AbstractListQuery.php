<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractListQuery implements QueryListInterface
{
    public function __construct(
        private Request $request,
        private string $entityClass,
        private string $alias,
        private string $sortField = 'id'
    ) {}

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getSortField(): string
    {
        return $this->sortField;
    }
}
