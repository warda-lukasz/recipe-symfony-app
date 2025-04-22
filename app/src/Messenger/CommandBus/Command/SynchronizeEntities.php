<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

class SynchronizeEntities implements CommandInterface
{
    /**
     * @param DtoInterface[] $dtos
     */
    public function __construct(
        private readonly array $dtos,
        private readonly string $entityClass,
    ) {}

    public function getDtos(): array
    {
        return $this->dtos;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }
}
