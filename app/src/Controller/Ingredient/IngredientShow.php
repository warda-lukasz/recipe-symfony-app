<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Controller\BaseController;
use App\Entity\Ingredient;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use App\Messenger\CommandBus\CommandBusInterface;
use App\Messenger\QueryBus\Query\IngredientImageUrlQuery;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[AsController]
#[Route('/ingredient/{id}', name: 'ingredient_show')]
class IngredientShow extends BaseController
{
    public function __construct(
        private MealDbClientInterface $mealDb,
        protected Environment $twig,
        protected QueryBusInterface $queryBus,
        protected CommandBusInterface $commandBus,
        protected FormFactoryInterface $formFactory,
        protected RouterInterface $router,
        protected RequestStack $requestStack,

    ) {
        parent::__construct(
            twig: $twig,
            queryBus: $queryBus,
            commandBus: $commandBus,
            formFactory: $formFactory,
            router: $router,
            requestStack: $requestStack
        );
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
