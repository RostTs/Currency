<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\CoinsCreateService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCertainCoinsCommand
 */
#[AsCommand(
    name: 'coins:list:update',
    description:'Saves certain coins list to DB'
)]
class UpdateCertainCoinsCommand extends Command
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
        $this->setName('coins:list:update')
        ->addArgument('list', InputArgument::IS_ARRAY,'List the coins by coingecko id')
        ->setDescription('Saves coins list to DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $list = $input->getArgument('list');
        $this->coinsCreateService->createForList($output,$list);

        return Command::SUCCESS;
    }
}