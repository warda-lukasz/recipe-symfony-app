<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\DtoInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: '')]
class Favourite implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private int $username;

    #[ORM\ManyToOne(
        targetEntity: Recipe::class,
        inversedBy: 'favourites',
    )]
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false)]
    private int $recipe;

    public function __construct(DtoInterface $dto)
    {
        $this->username = $dto->username;
        $this->recipe = $dto->recipe;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): int
    {
        return $this->username;
    }

    public function getRecipe(): int
    {
        return $this->recipe;
    }
}
