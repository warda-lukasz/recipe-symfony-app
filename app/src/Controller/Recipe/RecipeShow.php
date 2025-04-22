<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\ShowQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/show/{id}', name: 'recipe_show')]
class RecipeShow extends BaseController
{
    public function __invoke(string $id): Response
    {
        return $this->respond('recipe/show.html.twig', [
            'recipe' => $this->queryBus->query(
                new ShowQuery($id, Recipe::class, 'r')
            ),
        ]);
    }
}
