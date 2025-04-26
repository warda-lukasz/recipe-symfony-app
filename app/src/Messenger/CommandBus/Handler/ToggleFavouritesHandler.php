<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Dto\FavouriteDTO;
use App\Messenger\CommandBus\Command\ToggleFavourites;

class ToggleFavouritesHandler implements CommandHandlerInterface
{
    public function __construct() {}

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

    private function removeFavourite(FavouriteDTO $dto): void {}

    private function createFavourite(FavouriteDTO $dto): void {}
}
