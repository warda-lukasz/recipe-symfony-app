<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\ListQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/list', name: 'recipe_list')]
class RecipeList extends BaseController
{
    public function __invoke(): Response
    {
        return $this->respond('recipe/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery(
                    request: $this->requestStack->getCurrentRequest(),
                    entityClass: Recipe::class,
                    alias: 'r',
                    sortField: 'title'
                )
            ),
            'resultsForm' => $this->getResultsForm(),
        ]);
    }
}
