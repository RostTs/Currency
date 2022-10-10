<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsGeckoClient;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coin;
use DateTime;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use App\Factory\CoinFactory;

/**
 * Class CoinsCreateService
 */
class CoinsCreateService 
{
    /**
     * @param CoinsGeckoClient $coinsGeckoClient
     * @param CoinRepository $coinRepository
     * @param EntityManagerInterface $em
     * @param CoinFactory $coinFactory
     */
    public function __construct(
        private CoinsGeckoClient $coinsGeckoClient,
        private CoinRepository $coinRepository,
        private EntityManagerInterface $em,
        private CoinFactory $coinFactory
        ) {}


        //TODO: findBy change to chunks 50/100
    public function create(?OutputInterface $output): void
    {
        $coins = $this->coinsGeckoClient->getAll();

        $progressBar = $output ? new ProgressBar($output, count($coins)) : null;

        $output ? $progressBar->start() : null;

        foreach($coins as $singleCoin){
            if(!$this->coinRepository->findBy(['coingeckoId' => $singleCoin->id])){
                $coin = $this->coinFactory->createFromArray([
                    'coinGeckoId' => $singleCoin->id,
                    'symbol' => $singleCoin->symbol,
                    'name' => $singleCoin->name,
                    'isFavorite' => false,
                    'created' => new DateTime()
                ]);
                $this->em->persist($coin);
            }
                $output ? $progressBar->advance() : null;
        }
            $output ? $progressBar->finish() : null;

        $this->em->flush();
    }
}