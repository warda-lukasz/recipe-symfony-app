<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ResultsPerPageType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
class RecipeList extends BasedController
{
    public function __invoke(): Response
    {
        return $this->respond('recipe/index.html.twig', [
            'pagination' => $this->paginator->paginate([]),
            'resultsForm' => $this->formFactory->create(ResultsPerPageType::class)->createView(),
        ]);
    }
}
