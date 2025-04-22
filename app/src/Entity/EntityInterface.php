<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\DtoInterface;

interface EntityInterface
{
    public function __construct(DtoInterface $dto);
}
