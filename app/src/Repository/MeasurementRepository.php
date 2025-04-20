<?php

namespace App\Repository;

use App\Entity\Measurement;

class MeasurementRepository extends DoctrineRepository
{
    protected static string $entity = Measurement::class;
}
