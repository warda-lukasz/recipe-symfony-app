<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/show/{id}', name: 'recipe_show')]
class RecipeShow extends BaseController
{
    public function __invoke(Recipe $recipe): Response
    {
        return $this->respond('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
