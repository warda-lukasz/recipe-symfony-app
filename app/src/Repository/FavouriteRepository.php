<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Favourite;

class FavouriteRepository extends DoctrineRepository
{
    protected static string $entity = Favourite::class;
}
