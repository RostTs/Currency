<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Factory\CoinArchiveFactory;
use App\Repository\CoinArchiveRepository;
use DateTime;

/**
 * Class ArchivePricesService
 */
class ArchivePricesService
{

    /**
     * @param CoinRepository $coinRepository
     * @param CoinArchiveRepository $coinArchiveRepository
     * @param EntityManagerInterface $em
     * @param CoinArchiveFactory $coinArchiveFactory
     * @param CoinsGeckoClient $coinsGeckoClient
     */
    public function __construct(
        private CoinRepository $coinRepository,
        private CoinArchiveRepository $coinArchiveRepository,
        private EntityManagerInterface $em,
        private CoinArchiveFactory $coinArchiveFactory,
        private CoinsGeckoClient $coinsGeckoClient
        ) {}
    
        // TODO: output and update if exists
    /**
     * @param string[] $coinGeckoIds
     */
    public function archiveList(?OutputInterface $output, array $coinGeckoIds)
    {
        foreach ($coinGeckoIds as $coinGeckoId) {
            $coinPrices = $this->coinsGeckoClient->getSingleCoinPriceHistory($coinGeckoId);
            foreach ($coinPrices['prices'] as $price) {
                $date = new DateTime();
                $date->setTimestamp($price[0]/1000); // Time in milliseconds

                $coinArchive = $this->coinArchiveFactory->createFromArray([
                    'coinId' => $this->coinRepository->getByCoingeckoId($coinGeckoId),
                    'price' => $price[1],
                    'date' => $date
                ]);
                $this->em->persist($coinArchive);
            }
            $this->em->flush();
        }
    }
}