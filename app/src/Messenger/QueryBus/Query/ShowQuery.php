<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

final class ShowQuery implements QueryInterface
{
    public function __construct(
        private readonly string|int $id,
        private readonly string $entityClass,
        private readonly string $alias,
    ) {}

    public function getId(): string
    {
        return (string)$this->id;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}
