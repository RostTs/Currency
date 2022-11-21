<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\ArchivePrices;
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
     * @param ArchivePrices $archivePrices
     */
    public function __construct(
        private ArchivePrices $archivePrices
        )
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->setName('prices:archive')
        ->addArgument('list', InputArgument::IS_ARRAY,'List the coins by coingecko id')
        ->setDescription('Saves coins prices to archive');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->archivePrices->archive($output);

        return Command::SUCCESS;
    }
}