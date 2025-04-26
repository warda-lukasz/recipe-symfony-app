<?php

declare(strict_types=1);

namespace App\Messenger\CommandBus\Handler;

use App\Dto\RegistrationDTO;
use App\Dto\UserDTO;
use App\Entity\User;
use App\Factory\EntityFactory;
use App\Messenger\CommandBus\Command\RegisterUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class RegisterUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityFactory $entityFactory,
    ) {}

    public function __invoke(RegisterUser $command): void
    {
        /** @var RegistrationDTO $dto */
        $dto = $command->getDto();

        /** @var User $user */
        $user = $this->entityFactory->create(
            dto: new UserDTO(
                username: $command->getDto()->username,
            ),
            entityClass: User::class,
            dtoClass: UserDTO::class,
        );

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $dto->plainPassword,
            )
        );

        $this->em->persist($user);
        $this->em->flush();
    }
}
