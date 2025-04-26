<?php

declare(strict_types=1);

namespace App\Messenger\QueryBus\Query;

final class NewEntitiesToSynchronize extends AbstractQuery
{
    public function __construct(
        protected ?string $entityClass = null,
        protected ?string $alias = null,
        private ?string $apiQueryClass = null,
        private string $syncColumn = 'externalId',
    ) {
        parent::__construct($entityClass, $alias);
    }

    public function getApiQueryClass(): ?string
    {
        return $this->apiQueryClass;
    }

    public function getSyncColumn(): ?string
    {
        return $this->syncColumn;
    }
}
