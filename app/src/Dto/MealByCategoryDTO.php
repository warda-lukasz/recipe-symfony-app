<?php

declare(strict_types=1);

namespace App\Dto;

use App\Dto\DtoInterface;

class MealByCategoryDTO implements DtoInterface
{
    public function __construct(
        public readonly ?string $externalId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idMeal'],
        );
    }
}
