<?php

declare(strict_types=1);

namespace App\Dto;

class UserDTO implements DtoInterface
{
    public function __construct(
        public ?string $username = null,
    ) {}
}
