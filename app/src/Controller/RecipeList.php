<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\ListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/list', name: 'recipe_list')]
class RecipeList extends BaseController
{
    public function __invoke(Request $req): Response
    {
        return $this->respond('recipe/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery($req, Recipe::class, 'r', 'title')
            ),
            'resultsForm' => $this->getResultsForm(),
        ]);
    }
}
