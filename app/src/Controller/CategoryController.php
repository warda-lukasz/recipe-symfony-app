<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Form\ResultsPerPageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends BaseController
{
    static string $alias = 'c';
    static string $entity = Category::class;
    static string $sortField = 'name';

    #[Route('/category/list', name: 'category_list')]
    public function index(Request $req): Response
    {
        return $this->render('category/index.html.twig', [
            'pagination' => $this->paginate($req),
            'resultsForm' => $this->createForm(ResultsPerPageType::class)->createView(),
        ]);
    }

    #[Route('/category/{id}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
