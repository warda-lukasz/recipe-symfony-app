<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Controller\BaseController;
use App\Controller\RequestTrait;
use App\Entity\Recipe;
use App\Messenger\CommandBus\CommandBusInterface;
use App\Messenger\QueryBus\Query\ListQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/recipe/list', name: 'recipe_list')]
class RecipeList extends BaseController
{
    use RequestTrait;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly QueryBusInterface $queryBus,
        protected Environment $twig
    ) {
        parent::__construct($twig);
    }

    public function __invoke(): Response
    {
        return $this->respond('recipe/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery(
                    request: $this->getRequest(),
                    entityClass: Recipe::class,
                    alias: 'r',
                    sortField: 'title'
                )
            ),
        ]);
    }
}
