<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Ingredient;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/ingredient/{id}', name: 'ingredient_show')]
class IngredientShow extends BaseController
{
    public function __construct(
        protected Environment $twig,
        private MealDbClientInterface $mealDb,
    ) {
        parent::__construct($twig);
    }
    public function __invoke(Ingredient $ingredient): Response
    {
        return $this->respond('ingredient/show.html.twig', [
            'ingredient' => $ingredient,
            'thumbnail' => $this->mealDb::getIngrendientImageUrl($ingredient->getName()),
        ]);
    }
}
