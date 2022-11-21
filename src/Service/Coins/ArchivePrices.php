<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Factory\CoinArchiveFactory;

/**
 * Class CoinsCreateService
 */
class ArchivePrices 
{

    /**
     * @param CoinRepository $coinRepository
     * @param EntityManagerInterface $em
     * @param CoinArchiveFactory $coinArchiveFactory
     */
    public function __construct(
        private CoinRepository $coinRepository,
        private EntityManagerInterface $em,
        private CoinArchiveFactory $coinArchiveFactory
        ) {}

    public function archive(?OutputInterface $output)
    {
        $coins = $this->coinRepository->findAll();

        foreach ($coins as $coin) {
            $coinArchive = $this->coinArchiveFactory->createFromArray([
                'coinId' => $coin,
                'price' => $coin->getPrice()
            ]);
            $this->em->persist($coinArchive);
        }
        $this->em->flush();

    }

    
    public function archiveList(?OutputInterface $output, array $list)
    {
        $coins = $this->coinRepository->getByCoingeckoIds($list);

    }
}