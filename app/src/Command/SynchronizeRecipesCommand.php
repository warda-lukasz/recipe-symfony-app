<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\LoggingService;
use App\Service\MealDbSynchronizer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'app:sync-recipes',
    description: 'Synchronize recipes with the database',
)]
class SynchronizeRecipesCommand extends Command
{
    private const array SUPPORTED_TYPES = [
        'categories',
        'ingredients',
        'recipes',
    ];

    /**
     * @param SynchronizerInterface[] $synchronizers 
     */
    public function __construct(
        private readonly MealDbSynchronizer $recipeSynchronizer,
        private readonly LoggingService $logger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Synchronizing TheMealDb data with the database');
        $io->comment('This may take a while...');

        try {
            /** @var SynchronizerInterface $synchronizer */
            foreach (self::SUPPORTED_TYPES as $type) {
                $this->synchronize($type, $io);
            }
        } catch (Throwable $e) {
            $io->error('🤯' . $e->getMessage());

            $this->logger->logException($e, 'Error during synchronization with MealDB');

            return Command::FAILURE;
        }

        $io->success('Data have been synchronized successfully.');

        return Command::SUCCESS;
    }

    private function synchronize(string $type,  SymfonyStyle $io): void
    {
        $this->logger->startProcess($type . ' synchronization');
        $io->section("Synchronizing $type...");
        $this->recipeSynchronizer->synchronize($type);
        $this->logger->endProcess($type);
        $io->info("$type have been synchronized successfully.");
    }
}
