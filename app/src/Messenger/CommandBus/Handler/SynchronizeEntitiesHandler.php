<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Factory\EntityFactory;
use App\Messenger\CommandBus\Command\SynchronizeEntities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class SynchronizeEntitiesHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityFactory $entityFactory,
        private readonly EntityManagerInterface $em,
        private int $flushInterval = 100,
        private int $flushCount = 0,
    ) {}

    public function __invoke(SynchronizeEntities $command): void
    {
        foreach ($command->getDtos() as $dto) {
            $entity = $this->entityFactory->create(
                dto: $dto,
                entityClass: $command->getEntityClass(),
                dtoClass: get_class($dto)
            );

            if ($this->flushCount >= $this->flushInterval) {
                $this->em->flush();
                $this->em->clear();

                $this->flushCount = 0;
            }

            $this->em->persist($entity);
            $this->flushCount++;
        }

        $this->em->flush();
    }
}
