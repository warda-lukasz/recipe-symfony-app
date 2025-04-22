<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

trait RequestTrait
{
    protected function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
