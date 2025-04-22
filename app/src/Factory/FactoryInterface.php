<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\DtoInterface;
use App\Entity\EntityInterface;

interface FactoryInterface
{
    public function create(DtoInterface $dto, string $entityclass, string $dtoClass): EntityInterface;
}
