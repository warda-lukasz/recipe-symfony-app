<?php

namespace App\Entity;

use App\Dto\DtoInterface;
use App\Dto\MeasurementDTO;
use App\Exception\InvalidDtoException;
use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Ingredient::class, inversedBy: 'measurements', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'ingredient_id', referencedColumnName: 'id', nullable: false)]
    private Ingredient $ingredient;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'measurements', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false)]
    private Recipe $recipe;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $measure = null;

    public function __construct(DtoInterface $dto)
    {
        if (!$dto instanceof MeasurementDTO) {
            throw new InvalidDtoException($dto, MeasurementDTO::class);
        }

        $this->ingredient = $dto->ingredient;
        $this->recipe = $dto->recipe;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getMeasure(): ?string
    {
        return $this->measure;
    }

    public function setMeasure(?string $measure): self
    {
        $this->measure = $measure;

        return $this;
    }
}
