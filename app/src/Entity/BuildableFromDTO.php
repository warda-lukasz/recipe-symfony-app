<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\BuildableFromArray;

interface BuildableFromDTO
{
    public static function fromDto(BuildableFromArray $dto): self;
}
