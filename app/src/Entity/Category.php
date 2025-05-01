<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\CategoryDTO;
use App\Dto\DtoInterface;
use App\Exception\InvalidDtoException;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements EntityInterface
{
    use ExternalIdEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $thumb = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(
        targetEntity: Recipe::class,
        mappedBy: 'category',
        /* cascade: ['persist', 'remove'], */
        fetch: 'EXTRA_LAZY'
    )]
    private ?Collection $recipes = null;

    public function __construct(DtoInterface $dto)
    {
        if (!$dto instanceof CategoryDTO) {
            throw new InvalidDtoException($dto, CategoryDTO::class);
        }

        $this->name = $dto->name;
        $this->thumb = $dto->thumb;
        $this->description = $dto->description;
        $this->externalId = $dto->externalId;
        $this->recipes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getThumb(): ?string
    {
        return $this->thumb;
    }

    public function setThumb(string $thumb): self
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setCategory($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if (
            $this->recipes->removeElement($recipe) &&
            $recipe->getCategory() === $this
        ) {
            $recipe->setCategory(null);
        }

        return $this;
    }
}
