<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Dto\CommentDTO;
use App\Entity\Comment;
use App\Factory\EntityFactory;
use App\Messenger\CommandBus\Command\GenerateComments;
use App\Repository\CommentRepository;
use App\Repository\RecipeRepository;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateCommentsHandler
{
    private readonly Generator $faker;

    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly RecipeRepository $recipeRepository,
        private readonly EntityFactory $entityFactory,
    ) {
        $this->faker = Factory::create('en_US');
    }

    public function __invoke(GenerateComments $command)
    {
        foreach ($command->getRecipesIds() as $recipeId) {
            $commentsCount = mt_rand(15, 45);
            $recipe = $this->recipeRepository->find($recipeId);

            for ($i = 0; $i < $commentsCount; $i++) {
                $comment = $this->entityFactory->create(
                    dto: new CommentDTO(
                        author: $this->faker->name,
                        content: $this->faker->realText(mt_rand(50, 200)),
                        recipe: $recipe,
                    ),
                    dtoClass: CommentDTO::class,
                    entityClass: Comment::class
                );

                $this->commentRepository->save($comment, false);
            }

            $this->commentRepository->flush();
            $this->commentRepository->clear();
        }
    }
}
