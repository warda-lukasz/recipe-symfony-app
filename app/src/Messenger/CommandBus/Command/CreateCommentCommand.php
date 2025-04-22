<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Command;

use App\Dto\CommentDTO;

class CreateCommentCommand implements CommandInterface
{
    public function __construct(private CommentDTO $dto) {}

    public function getDto(): CommentDTO
    {
        return $this->dto;
    }
}
