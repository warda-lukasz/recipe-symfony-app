<?php

namespace App\AppCommand;

use App\Entity\Recipe;
use App\Messenger\CommandBus\Command\GenerateComments;
use App\Messenger\CommandBus\CommandBusInterface;
use App\Messenger\QueryBus\Query\EntitiesFieldAsArrayQuery;
use App\Messenger\QueryBus\QueryBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Throwable;

#[AsCommand(
    name: 'app:generate-comments',
    description: 'Generates sample comments for recipes',
)]
class GenerateCommentsCommand extends Command
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generating Comments');

        try {
            $this->commandBus->dispatch(
                new GenerateComments(
                    recipesIds: $this->queryBus->query(
                        new EntitiesFieldAsArrayQuery(
                            entityClass: Recipe::class,
                            alias: 'r',
                            field: 'id'
                        )
                    )
                )
            );

            $io->success('Comments generated successfully for all recipes!');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $io->error('Error while generating comments: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $io->progressFinish();
    }
}
