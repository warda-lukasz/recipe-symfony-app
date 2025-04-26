<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

final readonly class SynchronizeRecipes implements CommandInterface
{
    /**
     * @param DtoInterface[] $dtos
     */
    public function __construct(
        private array $dtos,
        private string $entityClass,
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
