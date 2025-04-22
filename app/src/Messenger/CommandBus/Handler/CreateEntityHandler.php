<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Factory\EntityFactory;
use App\Messenger\CommandBus\Command\CreateEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateEntityHandler
{
    public function __construct(
        private readonly EntityFactory $commentFactory,
        private readonly EntityManagerInterface $em,
    ) {}

    public function __invoke(CreateEntity $command): void
    {
        $entity = $this->commentFactory->create(
            dto: $command->getDto(),
            dtoClass: $command->getDtoClass(),
            entityClass: $command->getEntityClass(),
        );

        $this->em->getRepository($command->getEntityClass())
            ->save($entity);
    }
}
