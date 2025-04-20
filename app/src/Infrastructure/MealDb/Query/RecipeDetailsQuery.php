<?php

declare(strict_types=1);

namespace App\Infrastructure\MealDb\Query;

use App\Dto\RecipeDTO;

class RecipeDetailsQuery implements MealDbQueryInterface
{
    public function __construct(
        private readonly string $externalId
    ) {}

    public function getEndpoint(): string
    {
        return sprintf('lookup.php?i=%s', $this->externalId);
    }

    public function parseResponse(array $responseData): array
    {
        return [RecipeDTO::fromArray($responseData['meals'][0])];
    }
}
