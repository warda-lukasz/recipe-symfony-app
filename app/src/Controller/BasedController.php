<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BasedController
{
    public function __construct(
        protected Environment $twig
    ) {}

    protected function respond(string $route, array $data): Response
    {
        return new Response(
            $this->twig->render($route, $data)
        );
    }
}
