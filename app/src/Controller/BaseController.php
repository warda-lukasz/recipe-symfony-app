<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ResultsPerPageType;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BaseController
{
    public function __construct(
        protected Environment $twig,
        protected QueryBusInterface $queryBus,
        protected FormFactoryInterface $formFactory,
    ) {}

    protected function respond(string $route, array $data): Response
    {
        return new Response(
            $this->twig->render($route, $data)
        );
    }

    protected function getResultsForm(): FormView
    {
        return $this->createForm(ResultsPerPageType::class)->createView();
    }

    protected function createForm(string $formClass): FormInterface
    {
        return $this->formFactory->create($formClass);
    }
}
