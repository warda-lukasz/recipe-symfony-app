<?php

declare(strict_types=1);

namespace App\Dto;

interface DtoInterface
{
    public static function fromArray(array $data): self;
}
