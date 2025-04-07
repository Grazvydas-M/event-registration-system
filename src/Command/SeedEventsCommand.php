<?php

namespace App\Command;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:seed-event',
    description: 'Seed events'
)]
class SeedEventsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->addArgument('count', InputArgument::REQUIRED, 'Number of events to seed');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create('lt_LT');
        $count = $input->getArgument('count');

        for ($i = 0; $i < $count; $i++) {
            $event = new Event();
            $event->setName($faker->words(rand(1, 3), true))
                ->setDate($faker->dateTimeBetween('+1 week', '+2 months'))
                ->setAvailableSpots(rand(10, 100))
                ->setLocation($faker->city);

            $this->entityManager->persist($event);
        }

        $this->entityManager->flush();

        $output->writeln($count .' events have been successfully created.');

        return Command::SUCCESS;
    }
}