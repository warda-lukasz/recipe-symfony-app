<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Recipe;
use Symfony\Component\Validator\Constraints as Assert;

class CommentDTO implements DtoInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Author name is required')]
        #[Assert\Length(
            max: 255,
            min: 2,
            maxMessage: 'Author name cannot exceed {{ limit }} characters',
            minMessage: 'Author name must be at least {{ limit }} characters long',
        )]
        public ?string $author = null,

        #[Assert\NotBlank(message: 'Comment content is required')]
        #[Assert\Length(
            min: 1,
            max: 1000,
            maxMessage: 'Comment cannot exceed {{ limit }} characters',
            minMessage: 'Comment must be at least {{ limit }} characters long',
        )]
        public ?string $content = null,
        public ?int $recipeId = null,
        public ?Recipe $recipe = null,
    ) {}
}
