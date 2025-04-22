<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\BuildableFromArray;
use App\Dto\IngredientDTO;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use InvalidArgumentException;


#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ORM\Index(name: 'idx_ingredient_name', fields: ['name'])]
class Ingredient implements BuildableFromDTO, EntityInterface
{
    use ExternalIdEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $type = null;

    #[
        ORM\OneToMany(
            targetEntity: Measurement::class,
            mappedBy: 'ingredient',
            cascade: ['persist', 'remove']
        )
    ]
    private ?Collection $measurements;

    public function __construct()
    {
        $this->measurements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMeasurements(): ?Collection
    {
        return $this->measurements;
    }

    public function addMeasurement(Measurement $measurement): self
    {
        if (!$this->measurements->contains($measurement)) {
            $this->measurements->add($measurement);
        }


        return $this;
    }

    public function removeMeasurement(Measurement $measurement): self
    {
        $this->measurements->removeElement($measurement);

        return $this;
    }

    public static function fromDto(BuildableFromArray $dto): self
    {
        if (!$dto instanceof IngredientDTO) {
            throw new InvalidArgumentException(sprintf(
                'Expected instance of %s, got %s',
                IngredientDTO::class,
                get_class($dto)
            ));
        }

        return (new self())
            ->setExternalId($dto->externalId)
            ->setName($dto->name)
            ->setDescription($dto->description)
            ->setType($dto->type);
    }
}
