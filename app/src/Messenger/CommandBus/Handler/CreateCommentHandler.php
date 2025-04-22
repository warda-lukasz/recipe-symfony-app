<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Factory\CommentFactory;
use App\Messenger\CommandBus\Command\CreateCommentCommand;
use App\Repository\CommentRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCommentHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly CommentFactory $commentFactory,
    ) {
    }

    public function __invoke(CreateCommentCommand $command): void
    {
        $comment = $this->commentFactory->create($command->getDto());
        $this->commentRepository->save($comment);
    }
}
