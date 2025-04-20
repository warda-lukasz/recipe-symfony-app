<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class FavouritesDTO
{
    public function __construct(
        #[Assert\Type('array')]
        #[Assert\All([
            new Assert\Regex(
                pattern: '/^\d+$/',
                message: 'The value should be a valid integer.',
            ),
        ])]
        public ?array $favourites = null,
    ) {}
}
