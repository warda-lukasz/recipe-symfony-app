<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\DtoInterface;
use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Entity\Recipe;
use App\Messenger\QueryBus\Query\ShowQuery;

class CommentFactory extends AbstractFactory
{
    public function create(DtoInterface $dto): EntityInterface
    {
        return new Comment(
            author: $dto->author,
            content: $dto->content,
            recipe: $this->queryBus->query(
                new ShowQuery(id: $dto->recipeId, entityClass: Recipe::class, alias: 'r')
            )
        );
    }
}
