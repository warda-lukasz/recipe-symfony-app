<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

use App\Dto\FavouriteDTO;

final readonly class ToggleFavourites implements CommandInterface
{
    public function __construct(
        private FavouriteDTO $dto
    ) {}

    public function getDto(): FavouriteDTO
    {
        return $this->dto;
    }
}
