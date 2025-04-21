<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\FavouritesDTO;
use App\Form\ResultsPerPageType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
class FavouritesList
{
    public function __construct(
        private Environment $twig,
        private FormFactoryInterface $formFactory,
        private PaginatorInterface $paginator,
    ) {}

    public function __invoke(#[MapQueryString] FavouritesDTO $dto)
    {
        return new Response(
            $this->twig->render('recipe/index.html.twig', [
                'pagination' => $this->paginator->paginate([]),
                'resultsForm' => $this->formFactory->create(ResultsPerPageType::class)->createView(),
            ])
        );
    }
}
