<?php

namespace App\Command;

use App\Service\Coins\ArchivePricesCreateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\CoinsCreateService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateCertainCoinsCommand
 */
#[AsCommand(
    name: 'coins:list:update',
    description:'Saves certain coins list to DB'
)]
class CreateCertainCoinsCommand extends Command
{
    /**
     * @param CoinsCreateService $coinsCreateService
     * @param ArchivePricesService $archivePricesCreateService
     */
    public function __construct(
        private CoinsCreateService $coinsCreateService,
        private ArchivePricesCreateService $archivePricesCreateService
        )
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('list', InputArgument::IS_ARRAY,'List the coins by coingecko id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $list = $input->getArgument('list');
        $this->coinsCreateService->createForList($output,$list);
        $this->archivePricesCreateService->archiveList($output,$list);

        return Command::SUCCESS;
    }
}