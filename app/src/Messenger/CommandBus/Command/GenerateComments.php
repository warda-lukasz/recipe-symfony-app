<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

final readonly class GenerateComments implements CommandInterface
{
    public function __construct(
        private array $recipesIds
    ) {}

    public function getRecipesIds(): array
    {
        return $this->recipesIds;
    }
}
