<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\DtoInterface;
use App\Dto\RecipeDTO;
use App\Exception\InvalidDtoException;
use App\Repository\RecipeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Index(name: 'idx_recipe_title', fields: ['title'])]
class Recipe implements EntityInterface
{
    use ExternalIdEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\ManyToOne(
        targetEntity: Category::class,
        inversedBy: 'recipes',
        cascade: ['persist', 'remove'],
        fetch: 'EXTRA_LAZY',
    )]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $area = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $instructions = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $mealThumb = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $tags = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $source;

    #[ORM\Column(type: Types::DATE_MUTABLE, length: 255, nullable: true)]
    private ?DateTime $dateModified = null;

    #[
        ORM\OneToMany(
            targetEntity: Comment::class,
            mappedBy: 'recipe',
            cascade: ['persist', 'remove'],
            fetch: 'EXTRA_LAZY',
        )
    ]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $comments;

    #[
        ORM\OneToMany(
            targetEntity: Measurement::class,
            mappedBy: 'recipe',
            cascade: ['persist', 'remove']
        )
    ]
    private Collection $measurements;

    #[ORM\OneToMany(
        targetEntity: Favourite::class,
        mappedBy: 'recipe',
        cascade: ['persist', 'remove'],
        fetch: 'EXTRA_LAZY',
    )]
    private Collection $favourites;

    public function __construct(DtoInterface $dto)
    {
        if (!$dto instanceof RecipeDTO) {
            throw new InvalidDtoException($dto, RecipeDTO::class);
        }

        $this->externalId = $dto->externalId;
        $this->title = $dto->title;
        $this->area = $dto->area;
        $this->instructions = $dto->instructions;
        $this->mealThumb = $dto->thumb;
        $this->tags = $dto->tags;
        $this->youtube = $dto->yt;
        $this->source = $dto->source;
        $this->dateModified = $dto->dateModified;

        $this->measurements = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favourites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getMealThumb(): ?string
    {
        return $this->mealThumb;
    }

    public function setMealThumb(string $mealThumb): self
    {
        $this->mealThumb = $mealThumb;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDateModified(): ?DateTime
    {
        return $this->dateModified;
    }

    public function setDateModified(DateTime $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getMeasurements(): Collection
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

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getRecentComments(int $limit = 20): Collection
    {
        $criteria = (new Criteria())
            ->setMaxResults($limit)
            ->orderBy(['createdAt' => 'DESC']);

        return $this->comments->matching($criteria);
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    public function addFavourite(Favourite $fav): self
    {
        if (!$this->favourites->contains($fav)) {
            $this->favourites->add($fav);
        }

        return $this;
    }

    public function removeFavourite(Favourite $fav): self
    {
        if ($this->favourites->contains($fav)) {
            $this->favourites->removeElement($fav);
        }

        return $this;
    }

    public function isFavouredByUser(string $username): bool
    {
        foreach ($this->favourites as $favourite) {
            if ($favourite->getUsername() === $username) {
                return true;
            }
        }

        return false;
    }
}
