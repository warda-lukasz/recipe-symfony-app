<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

class IngredientImageUrlQuery extends AbstractQuery
{
    public function __construct(
        private string $id,
    ) {
        parent::__construct();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
