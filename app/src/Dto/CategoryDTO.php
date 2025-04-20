<?php

declare(strict_types=1);

namespace App\Dto;

class CategoryDTO implements DtoInterface
{
    public function __construct(
        public readonly ?string $externalId,
        public readonly ?string $name = null,
        public readonly ?string $thumb = null,
        public readonly ?string $description = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['idCategory'],
            $data['strCategory'],
            $data['strCategoryThumb'],
            $data['strCategoryDescription'],
        );
    }
}
