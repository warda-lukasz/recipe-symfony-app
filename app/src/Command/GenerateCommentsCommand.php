<?php

namespace App\Command;

use App\Entity\Comment;
use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:generate-comments',
    description: 'Generates sample comments for recipes',
)]
class GenerateCommentsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Generuj przykładowe komentarze dla przepisów');
    }

    /**
     * HACK: 
     * Due to generating a large number of comments,
     * in order to avoid memory overload,
     * we periodically flush and clear the EntityManager.
     * Also, we iterate over the recipe IDs and
     * pull new Recipe each time for same reason.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $faker = Factory::create('en_US');

        $recipeIds = $this->entityManager->createQuery('SELECT r.id FROM App\Entity\Recipe r')->getResult();
        $io->title('Generating Comments');
        $io->progressStart(count($recipeIds));

        foreach ($recipeIds as $recipeData) {
            $recipeId = $recipeData['id'];

            $recipe = $this->entityManager->find(Recipe::class, $recipeId);
            if (!$recipe) continue;

            $commentsCount = mt_rand(15, 45);

            for ($i = 0; $i < $commentsCount; $i++) {
                $comment = (new Comment())
                    ->setContent($faker->realText(mt_rand(50, 200)))
                    ->setAuthor($faker->name)
                    ->setCreatedAt(new DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')))
                    ->setRecipe($recipe);

                $this->entityManager->persist($comment);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
            $io->progressAdvance();
        }


        $io->progressFinish();
        $io->success('Comments generated successfully for all recipes!');

        return Command::SUCCESS;
    }
}
