<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/recipe/{id}/comments', name: 'recipe_all_comments')]
class RecipeComments extends BaseController
{
    public function __construct(
        protected readonly QueryBusInterface $queryBus,
        protected Environment $twig
    ) {
        parent::__construct($twig);
    }

    public function __invoke(string $id): Response
    {
        return $this->respond('recipe/allComments.html.twig', [
            'recipe' => $this->queryBus->query(
                new ShowQuery($id, Recipe::class, 'r')
            ),
        ]);
    }
}
