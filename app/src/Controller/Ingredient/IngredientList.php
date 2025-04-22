<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Controller\BaseController;
use App\Controller\RequestTrait;
use App\Entity\Ingredient;
use App\Messenger\QueryBus\Query\ListQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/ingredient/list', name: 'ingredient_list')]
class IngredientList extends BaseController
{
    use RequestTrait;

    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly RequestStack $requestStack,
        protected Environment $twig
    ) {
        parent::__construct($twig);
    }
    public function __invoke(): Response
    {
        return $this->respond('ingredient/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery(
                    request: $this->getRequest(),
                    entityClass: Ingredient::class,
                    alias: 'i',
                    sortField: 'name'
                )
            ),
        ]);
    }
}
