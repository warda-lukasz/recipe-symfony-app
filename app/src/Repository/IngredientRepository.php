<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ingredient;

class IngredientRepository extends DoctrineRepository
{
    protected static string $entity = Ingredient::class;

    public function findAllExternalIds(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.externalId')
            ->getQuery()
            ->getSingleColumnResult();
    }
}
