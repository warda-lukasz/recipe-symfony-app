<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\BaseController;
use App\Controller\RequestTrait;
use App\Entity\Category;
use App\Messenger\QueryBus\Query\ListQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/category/list', name: 'category_list')]
class CategoryList extends BaseController
{
    use RequestTrait;

    public function __construct(
        protected QueryBusInterface $queryBus,
        protected RequestStack $requestStack,
        protected Environment $twig,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(): Response
    {
        return $this->respond('category/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery(
                    request: $this->getRequest(),
                    entityClass: Category::class,
                    alias: 'c',
                    sortField: 'name'
                )
            ),
        ]);
    }
}
