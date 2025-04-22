<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Controller\BaseController;
use App\Entity\Ingredient;
use App\Messenger\QueryBus\Query\ListQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/ingredient/list', name: 'ingredient_list')]
class IngredientList extends BaseController
{
    public function __invoke(): Response
    {
        return $this->respond('ingredient/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery(
                    request: $this->requestStack->getCurrentRequest(),
                    entityClass: Ingredient::class,
                    alias: 'i',
                    sortField: 'name'
                )
            ),
            'resultsForm' => $this->getResultsForm(),
        ]);
    }
}
