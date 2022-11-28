<?php

namespace App\Command;

use App\Repository\CoinRepository;
use App\Service\Coins\ArchivePricesCreateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Service\Coins\CoinsCreateService;
use App\Service\Coins\CoinUpdateService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DailyPriceUpdateCommand
 */
#[AsCommand(
    name: 'coins:price:update',
    description:'Update coins current price'
)]
class DailyPriceUpdateCommand extends Command
{
    /**
     * @param CoinRepository $coinRepository
     * @param CoinUpdateService $coinUpdateService
     * @param ArchivePricesCreateService $archivePricesCreateService
     */
    public function __construct(
        private CoinRepository $coinRepository,
        private CoinUpdateService $coinUpdateService,
        private ArchivePricesCreateService $archivePricesCreateService
        )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $coins = $this->coinRepository->findAll();
        foreach ($coins as $coin) {
            $coinOldPrice = $this->coinUpdateService->updateСoinsCurrentPrice($coin);
            $this->archivePricesCreateService->archiveSinglePrice($coin, $coinOldPrice);
        }

        return Command::SUCCESS;
    }
}