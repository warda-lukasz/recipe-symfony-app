<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Dto\FavouriteDTO;
use App\Entity\Favourite;
use App\Factory\EntityFactory;
use App\Messenger\CommandBus\Command\ToggleFavourites;
use App\Repository\FavouriteRepository;
use App\Repository\RecipeRepository;

class ToggleFavouritesHandler implements CommandHandlerInterface
{
    public function __construct(
        private RecipeRepository $recipeRepo,
        private FavouriteRepository $favouriteRepo,
        private EntityFactory $entityFactory,

    ) {}

    public function __invoke(ToggleFavourites $command): void
    {
        $dto = $command->getDto();
        $recipe = $dto->recipe;
        $username = $dto->username;

        if ($recipe->isFavouredByUser($username)) {
            $this->removeFavourite($dto);
        } else {
            $this->createFavourite($dto);
        }
    }

    private function removeFavourite(FavouriteDTO $dto): void
    {
        $favourite = $this->favouriteRepo->findOneBy([
            'recipe' => $dto->recipe,
            'username' => $dto->username,
        ]);

        $this->favouriteRepo->remove($favourite);
    }

    private function createFavourite(FavouriteDTO $dto): void
    {
        $recipe = $dto->recipe;
        $favourite = $this->entityFactory->create(
            dto: $dto,
            dtoClass: FavouriteDTO::class,
            entityClass: Favourite::class
        );

        $recipe->addFavourite($favourite);
        $this->favouriteRepo->save($favourite);
    }
}
