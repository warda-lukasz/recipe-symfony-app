<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/recipe/{id}/comments', name: 'recipe_all_comments')]
class RecipeComments extends BasedController
{
    public function __invoke(Recipe $recipe): Response
    {
        return $this->respond('recipe/allComments.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
