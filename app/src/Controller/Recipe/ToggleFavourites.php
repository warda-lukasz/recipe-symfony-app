<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\AddFlashTrait;
use App\Controller\BaseController;
use App\Dto\FavouriteDTO;
use App\Entity\Recipe;
use App\Messenger\CommandBus\Command\ToggleFavourites as CommandToggleFavourites;
use App\Messenger\CommandBus\CommandBusInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[AsController]
#[Route('recipe/{id}/toggle-favourites', name: 'recipe_toggle_favourites')]
class ToggleFavourites extends BaseController
{

    use AddFlashTrait;

    public function __construct(
        protected Environment $twig,
        private Security $security,
        private CommandBusInterface $commandBus,
        private RequestStack $requestStack,
        private RouterInterface $router
    ) {
        parent::__construct($twig);
    }

    public function __invoke(Recipe $recipe): Response
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

        if ($recipe->isFavouredByUser($username)) {
            $this->addFlash('success', "Recipe {$recipe->getTitle()} removed from favourites");
        } else {
            $this->addFlash('success', "Recipe {$recipe->getTitle()} added to favourites");
        }

        return new RedirectResponse($this->router->generate('recipe_list'));
    }
}
