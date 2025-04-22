<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Controller\BaseController;
use App\Entity\Ingredient;
use App\Messenger\QueryBus\Query\IngredientImageUrlQuery;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/ingredient/{id}', name: 'ingredient_show')]
class IngredientShow extends BaseController
{
    public function __construct(
        protected Environment $twig,
        protected QueryBusInterface $queryBus,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(string $id): Response
    {
        return $this->respond('ingredient/show.html.twig', [
            'ingredient' => $this->queryBus->query(
                new ShowQuery($id, Ingredient::class, 'i')
            ),
            'thumbnail' => $this->queryBus->query(
                new IngredientImageUrlQuery($id)
            ),
        ]);
    }
}
