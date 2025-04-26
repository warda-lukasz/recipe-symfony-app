<?php

declare(strict_types=1);

namespace App\Dto;

class RegistrationDTO implements DtoInterface
{
    public function __construct(
        public ?string $username = null,
        public ?string $plainPassword = null,
    ) {}
}
