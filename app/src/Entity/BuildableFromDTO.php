<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\DtoInterface;

interface BuildableFromDTO
{
    public static function fromDto(DtoInterface $dto): self;
}
