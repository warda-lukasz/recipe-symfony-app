<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractListQuery extends AbstractQuery implements QueryListInterface
{
    public function __construct(
        protected Request $request,
        protected string $sortField = 'id',
        protected ?string $entityClass = null,
        protected ?string $alias = null,
    ) {
        parent::__construct($entityClass, $alias);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getSortField(): string
    {
        return $this->sortField;
    }
}
