<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\ArchivePrices;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SaveCoinsCommand
 */
#[AsCommand(
    name: 'prices:archive',
    description:'Saves coins prices to archive'
)]
class ArchiveCoinsPricesCommand extends Command
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
        ->setDescription('Saves coins prices to archive');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->archivePrices->archive($output);

        return Command::SUCCESS;
    }
}