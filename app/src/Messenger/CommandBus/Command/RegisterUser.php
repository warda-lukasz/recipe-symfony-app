<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

use App\Dto\RegistrationDTO;

final readonly class RegisterUser implements CommandInterface
{
    public function __construct(
        private RegistrationDTO $dto
    ) {}

    public function getDto(): RegistrationDTO
    {
        return $this->dto;
    }
}
