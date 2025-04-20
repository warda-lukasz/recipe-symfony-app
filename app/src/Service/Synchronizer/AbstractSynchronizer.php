<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

use App\Service\Synchronizer\SynchronizerInterface;

abstract class AbstractSynchronizer implements SynchronizerInterface
{
    public static string $type = '';

    public function supports(string $type): bool
    {
        return $type === static::$type;
    }
}
