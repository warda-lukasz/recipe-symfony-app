<?php

declare(strict_types=1);

namespace App\Controller;

trait CreateFormTrait
{
    protected function createForm(string $formClass, object $entity, array $options = []): object
    {
        return $this->formFactory->create($formClass, $entity, $options);
    }
}
