<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class MealDbSynchronizer
{
    /**
     * @param SynchronizerInterface[] $synchronizers
     */
    public function __construct(
        #[TaggedIterator('app.synchronizer')] private readonly iterable $synchronizers,
    ) {}

    public function synchronize(string $type = null): void
    {
        if (!$type) {
            $this->synchronizeAll();
        } else {
            // NOTE: Remember to add the type to
            // SynchronizeRecipesCommand::SUPPORTED_TYPES
            $this->synchronizeByType($type);
        }
    }

    public function synchronizeAll(): void
    {
        /** @var SynchronizerInterface $synchronizer */
        foreach ($this->synchronizers as $synchronizer) {
            $synchronizer->synchronize();
        }
    }

    public function synchronizeByType(string $type): void
    {
        /** @var SynchronizerInterface $synchronizer */
        foreach ($this->synchronizers as $synchronizer) {
            if ($synchronizer->supports($type)) {
                $synchronizer->synchronize();
            }
        }
    }
}
