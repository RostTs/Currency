<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\CoinsCreateService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SaveCoinsCommand
 */
#[AsCommand(
    name: 'coins:update',
    description:'Saves coins list to DB'
)]
class UpdateCoinsCommand extends Command
{
    /**
     * @param CoinsCreateService $coinsCreateService
     */
    public function __construct(
        private CoinsCreateService $coinsCreateService
        )
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('coins:save')
        ->setDescription('Saves coins list to DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->coinsCreateService->create($output);

        return Command::SUCCESS;
    }
}