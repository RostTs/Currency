<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use App\Factory\CoinArchiveFactory;
use DateTime;
use App\Entity\Coin;

/**
 * Class ArchivePricesCreateService
 */
class ArchivePricesCreateService
{
    private const PROGRESS_MESSAGE = 'Setting prices for coins';

    /**
     * @param CoinRepository $coinRepository
     * @param EntityManagerInterface $em
     * @param CoinArchiveFactory $coinArchiveFactory
     * @param CoinsGeckoClient $coinsGeckoClient
     */
    public function __construct(
        private CoinRepository $coinRepository,
        private EntityManagerInterface $em,
        private CoinArchiveFactory $coinArchiveFactory,
        private CoinsGeckoClient $coinsGeckoClient
        ) {}
    
        // TODO: update if exists
    /**
     * @param string[] $coinGeckoIds
     */
    public function archiveList(?OutputInterface $output, array $coinGeckoIds): void
    {
        $progressBar = $output ? new ProgressBar($output, count($coinGeckoIds)) : null;
        $progressBar?->setMessage(self::PROGRESS_MESSAGE);
        $progressBar?->start();

        foreach ($coinGeckoIds as $coinGeckoId) {
            $coinPrices = $this->coinsGeckoClient->getSingleCoinPriceHistory($coinGeckoId);
            foreach ($coinPrices['prices'] as $price) {
                $date = new DateTime();
                $date->setTimestamp($price[0]/1000); // Time in milliseconds

                $coinArchive = $this->coinArchiveFactory->createFromArray([
                    'coin' => $this->coinRepository->getByCoingeckoId($coinGeckoId),
                    'price' => $price[1],
                    'date' => $date
                ]);
                $this->em->persist($coinArchive);
            }
            $this->em->flush();
            $progressBar?->advance();
        }
        $progressBar?->finish();
    }

    /**
     * @param Coin $coin
     * @param float$price
     */
    public function archiveSinglePrice(Coin $coin, float $price): void
    {
        $coinArchive = $this->coinArchiveFactory->createFromArray([
            'coin' => $coin,
            'price' => $price,
            'date' => new DateTime()
        ]);
        $this->em->persist($coinArchive);
        $this->em->flush();
    }
}
