<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

use App\Dto\DtoInterface;

final readonly class RemoveEntity implements CommandInterface
{
    public function __construct(
        private DtoInterface $dto,
        private string $entityClass
    ) {}

    public function getDto(): DtoInterface
    {
        return $this->dto;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }
}
