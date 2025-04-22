<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\DtoInterface;
use App\Entity\EntityInterface;
use App\Exception\InvalidDtoException;

class EntityFactory extends AbstractFactory
{
    public function create(DtoInterface $dto, string $entityClass, string $dtoClass): EntityInterface
    {
        if (!$dto instanceof $dtoClass) {
            throw new InvalidDtoException($dto, $dtoClass);
        }

        return new $entityClass($dto);
    }
}
