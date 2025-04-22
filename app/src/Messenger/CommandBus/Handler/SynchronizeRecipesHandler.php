<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Factory\RecipeFactory;
use App\Messenger\CommandBus\Command\SynchronizeRecipes;
use App\Repository\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SynchronizeRecipesHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RecipeFactory $recipeFactory,
        private readonly RecipeRepository $recipeRepo,
        private readonly int $chunk = 10,
        private int $counter = 0,
    ) {}

    public function __invoke(SynchronizeRecipes $command): void
    {
        foreach ($command->getDtos() as $dto) {
            $recipe = $this->recipeFactory->create($dto);
            $this->recipeRepo->save($recipe, false);

            if ($this->counter >= $this->chunk) {
                $this->recipeRepo->flush();
                $this->recipeRepo->clear();
                $this->counter = 0;
            }

            $this->counter++;
        }
    }
}
