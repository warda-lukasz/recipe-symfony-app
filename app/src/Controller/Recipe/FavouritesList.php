<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Controller\RequestTrait;
use App\Dto\FavouritesDTO;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\FavouritesQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
class FavouritesList extends BaseController
{
    use RequestTrait;

    public function __construct(
        private readonly FavouritesDTO $favouritesDTO,
        private readonly QueryBusInterface $queryBus,
        private readonly RequestStack $requestStack,
        protected Environment $twig
    ) {
        parent::__construct($twig);
    }
    #[Route('/recipe/favourites', name: 'recipe_favs')]
    public function __invoke(#[MapQueryString] FavouritesDTO $dto): Response
    {
        return $this->respond('recipe/favs.html.twig', [
            'pagination' => $this->queryBus->query(
                new FavouritesQuery(
                    dto: $dto,
                    request: $this->getRequest(),
                    entityClass: Recipe::class,
                    alias: 'r',
                    sortField: 'title'
                )
            ),
        ]);
    }
}
