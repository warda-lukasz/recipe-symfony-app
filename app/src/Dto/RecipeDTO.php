<?php

declare(strict_types=1);

namespace App\Dto;

class RecipeDTO implements BuildableFromArray, DtoInterface
{

    public function __construct(
        public readonly ?string $externalId = null,
        public readonly ?string $title = null,
        public readonly ?string $category = null,
        public readonly ?string $area = null,
        public readonly ?string $instructions = null,
        public readonly ?string $thumb = null,
        public readonly ?string $tags = null,
        public readonly ?string $yt = null,
        public readonly ?array $ingredients = null,
        public readonly ?array $measurements = null,
        public readonly ?string $source = null,
        public readonly ?string $dateModified = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            externalId: $data['idMeal'],
            title: $data['strMeal'] ?? null,
            category: $data['strCategory'] ?? null,
            area: $data['strArea'] ?? null,
            instructions: $data['strInstructions'] ?? null,
            thumb: $data['strMealThumb'] ?? null,
            tags: $data['strTags'] ?? null,
            yt: $data['strYoutube'] ?? null,
            ingredients: array_values(
                array_filter(
                    $data,
                    fn($key) =>
                    str_starts_with($key, 'strIngredient'),
                    ARRAY_FILTER_USE_KEY
                )
            ),
            measurements: array_values(
                array_filter(
                    $data,
                    fn($key) =>
                    str_starts_with($key, 'strMeasure'),
                    ARRAY_FILTER_USE_KEY
                )
            ),
            source: $data['strSource'] ?? null,
            dateModified: $data['dateModified'] ?? null
        );
    }
}
