<?php

declare(strict_types=1);

namespace App\Dto;

class IngredientDTO implements BuildableFromArray, DtoInterface
{
    public function __construct(
        public readonly ?string $externalId = null,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $type = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idIngredient'],
            $data['strIngredient'],
            $data['strDescription'],
            $data['strType'],
        );
    }
}
