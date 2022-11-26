<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\ArchivePrices;
use App\Service\Coins\ArchivePricesService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class ArchiveCertainCoinsPrices
 */
#[AsCommand(
    name: 'prices:list:archive',
    description:'Saves coins prices to archive'
)]
class ArchiveCertainCoinsPrices extends Command
{
    /**
     * @param ArchivePricesService $archivePrices
     */
    public function __construct(
        private ArchivePricesService $archivePrices
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
        $this->archivePrices->archiveList($output, $list);

        return Command::SUCCESS;
    }
}