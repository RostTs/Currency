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
    name: 'coins:save',
    description:'Saves coins list to DB'
)]
class SaveCoinsCommand extends Command
{
    /**
     * @param CoinsCreateService $coinsCreateService
     */
    public function __construct(private CoinsCreateService $coinsCreateService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->coinsCreateService->create();

        return Command::SUCCESS;
    }
}
