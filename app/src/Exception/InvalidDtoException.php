<?php

declare(strict_types=1);

namespace App\Exception;

use App\Dto\DtoInterface;
use InvalidArgumentException;

class InvalidDtoException extends InvalidArgumentException
{
    public function __construct(DtoInterface $dto, string $expectedDto)
    {
        $msg = sprintf(
            'Expected instance of %s, got %s',
            $expectedDto,
            get_class($dto)
        );

        parent::__construct($msg);
    }
}
