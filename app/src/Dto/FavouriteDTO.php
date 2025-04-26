<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Recipe;

class FavouriteDTO implements DtoInterface
{
    public function __construct(
        public ?string $username = null,
        public ?Recipe $recipe = null
    ) {}
}
