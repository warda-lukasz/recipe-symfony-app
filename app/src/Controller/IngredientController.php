<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\ResultsPerPageType;
use App\Infrastructure\MealDb\Client\MealDbClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IngredientController extends BaseController
{
    private MealDbClientInterface $mealDbClient;

    static string $alias = 'i';
    static string $entity = Ingredient::class;
    static string $sortField = 'name';

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        MealDbClientInterface $mealDbClient
    ) {
        parent::__construct($em, $paginator);
        $this->mealDbClient = $mealDbClient;
    }

    #[Route('/ingredient/list', name: 'ingredient_list')]
    public function index(Request $req): Response
    {
        return $this->render('ingredient/index.html.twig', [
            'pagination' => $this->paginate($req),
            'resultsForm' => $this->createForm(ResultsPerPageType::class)->createView(),
        ]);
    }
}
