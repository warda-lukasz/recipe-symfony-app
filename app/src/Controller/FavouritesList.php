<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\FavouritesDTO;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\FavouritesQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class FavouritesList extends BaseController
{
    #[Route('/recipe/favourites', name: 'recipe_favs')]
    public function __invoke(#[MapQueryString] FavouritesDTO $dto, Request $request): Response
    {
        return $this->respond('recipe/favs.html.twig', [
            'pagination' => $this->queryBus->query(
                new FavouritesQuery($dto, $request, Recipe::class, 'r', 'title')
            ),
            'resultsForm' => $this->getResultsForm(),
        ]);
    }
}
