<?php

declare(strict_types=1);

namespace App\Controller;

trait AddFlashTrait
{
    protected function addFlash(string $type, string $message): void
    {
        $this->requestStack->getSession()->getFlashBag()->add($type, $message);
    }
}
