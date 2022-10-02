<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsGeckoClient;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coin;
use DateTime;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CoinsCreateService
 */
class CoinsCreateService 
{
    /** @var CoinsGeckoClient */
    private $coinsGeckoClient;

    /** @var CoinRepository */
    private $coinRepository;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param CoinsGeckoClient $coinsGeckoClient
     * @param CoinRepository $coinRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        CoinsGeckoClient $coinsGeckoClient,
        CoinRepository $coinRepository,
        EntityManagerInterface $em
        )
    {
        $this->coinsGeckoClient = $coinsGeckoClient;
        $this->coinRepository = $coinRepository;
        $this->em = $em;
    }

    public function create(OutputInterface $output): void
    {
        $coins = $this->coinsGeckoClient->getAll();

        $progressBar = new ProgressBar($output, count($coins));

        $progressBar->start();
        foreach($coins as $singleCoin){
            if(!$this->coinRepository->findOneBy(['coingeckoId' => $singleCoin->id])){
                $coin = new Coin();
                $coin->setCoingeckoId($singleCoin->id);
                $coin->setSymbol($singleCoin->symbol);
                $coin->setName($singleCoin->name);
                $coin->setIsFavorite(false);
                $coin->setCreated(new DateTime());

                $this->em->persist($coin);
            }
            $progressBar->advance();
        }
        $progressBar->finish();

        $this->em->flush();
    }
}