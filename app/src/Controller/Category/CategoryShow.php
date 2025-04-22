<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Controller\BaseController;
use App\Entity\Category;
use App\Messenger\QueryBus\Query\ShowQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/category/{id}', name: 'category_show')]
class CategoryShow extends BaseController
{
    public function __invoke(string $id): Response
    {
        return $this->respond('category/show.html.twig', [
            'category' => $this->queryBus->query(
                new ShowQuery($id, Category::class, 'c')
            ),
        ]);
    }
}
