<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;

class CommentRepository extends DoctrineRepository
{
    protected static string $entity = Comment::class;
}
