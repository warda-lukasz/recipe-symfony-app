<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Ingredient;
use App\Entity\Recipe;

class MeasurementDTO implements DtoInterface
{
    public function __construct(
        public ?Ingredient $ingredient = null,
        public ?Recipe $recipe = null,
    ) {}
}
