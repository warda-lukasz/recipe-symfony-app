<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

class EntitiesFieldAsArrayQuery extends AbstractQuery 
{
    public function __construct(
        protected ?string $entityClass,
        protected ?string $alias,
        private ?string $field
    )
    {
        parent::__construct(
            entityClass: $entityClass,
            alias: $alias
        );
    }

    public function getField(): ?string
    {
        return $this->field;
    }
}
