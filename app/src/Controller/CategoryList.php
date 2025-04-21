<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Messenger\QueryBus\Query\ListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/category/list', name: 'category_list')]
class CategoryList extends BaseController
{
    public function __invoke(Request $req): Response
    {
        return $this->respond('category/index.html.twig', [
            'pagination' => $this->queryBus->query(
                new ListQuery($req, Category::class, 'c', 'name')
            ),
            'resultsForm' => $this->getResultsForm(),
        ]);
    }
}
