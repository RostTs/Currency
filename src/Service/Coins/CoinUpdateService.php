<?php

namespace App\Service\Coins;

use App\Entity\Coin;
use App\Params\CoinsParams;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Coins\CoinsGeckoClient;
use DateTime;

/**
 * Class CoinUpdateService
 */
class CoinUpdateService
{

    /**
     * @param EntityManagerInterface $em
     * @param CoinsGeckoClient $coinsGeckoClient
     */
    public function __construct(
        private EntityManagerInterface $em,
        private CoinsGeckoClient $coinsGeckoClient
    ) {}


    /**
     * @param CoinsParams $coinsParams
     * @param Coin $coin
     */
    public function update(CoinsParams $coinsParams,Coin $coin): void
    {
        if($coinsParams->getIsFavorite() !== null){
            $coin->setIsFavorite($coinsParams->getIsFavorite());
        }
        $this->em->persist($coin);
        $this->em->flush($coin);
    }

    /**
     * @param Coin $coin
     * 
     * @return float
     */
    public function updateCoinsCurrentPrice(Coin $coin): float
    {
        $coinOldPrice = $coin->getPrice();
        $coinCurrentPrice = $this->coinsGeckoClient->getSingleCoinSimplePrice($coin->getCoingeckoId());

        $coin->setPrice($coinCurrentPrice);

        $this->em->persist($coin);

        return $coinOldPrice;

    }
}
