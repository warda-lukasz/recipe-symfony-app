<?php

declare(strict_types=1);

namespace App\Service\Synchronizer;

interface SynchronizerInterface
{
    public function synchronize(): void;
    public function supports(string $type): bool;
}
