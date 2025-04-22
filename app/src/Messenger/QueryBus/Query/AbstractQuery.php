<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

abstract class AbstractQuery implements QueryInterface
{
    public function __construct(
        protected ?string $entityClass = null,
        protected ?string $alias = null,
    ) {}

    public function getEntityClass(): ?string
    {
        return $this->entityClass;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }
}
