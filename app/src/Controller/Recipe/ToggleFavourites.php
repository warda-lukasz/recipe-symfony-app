<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Dto\FavouriteDTO;
use App\Entity\Recipe;
use App\Messenger\CommandBus\Command\ToggleFavourites as CommandToggleFavourites;
use App\Messenger\CommandBus\CommandBusInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('recipe/{id}/toggle-favourites', name: 'recipe_toggle_favourites')]
class ToggleFavourites extends BaseController
{
    public function __construct(
        protected Environment $twig,
        private Security $security,
        private CommandBusInterface $commandBus,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(Recipe $recipe): JsonResponse
    {
        $username = $this->security->getUser()->getUsername();
        $this->commandBus->dispatch(
            new CommandToggleFavourites(
                new FavouriteDTO(
                    username: $username,
                    recipe: $recipe
                )
            )
        );

        return new JsonResponse(
            [
                'status' => 'success',
                'message' => 'Recipe toggled as favourite',
                'isFav' => $recipe->isFavouredByUser($username),
            ],
            Response::HTTP_OK
        );
    }
}
