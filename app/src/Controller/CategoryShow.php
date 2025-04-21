<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/category/{id}', name: 'category_show')]
class CategoryShow extends BaseController
{
    public function __invoke(Category $category)
    {
        return $this->respond('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
