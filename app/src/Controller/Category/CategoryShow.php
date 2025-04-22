<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\BaseController;
use App\Entity\Category;
use App\Messenger\QueryBus\Query\ShowQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/category/{id}', name: 'category_show')]
class CategoryShow extends BaseController
{
    public function __construct(
        protected QueryBusInterface $queryBus,
        protected Environment $twig,
    ) {
        parent::__construct($twig);
    }

    public function __invoke(string $id): Response
    {
        return $this->respond('category/show.html.twig', [
            'category' => $this->queryBus->query(
                new ShowQuery($id, Category::class, 'c')
            ),
        ]);
    }
}
