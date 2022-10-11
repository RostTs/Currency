<?php

namespace App\Service\Coins;

use App\Entity\Coin;
use App\Params\CoinsParams;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CoinsUpdateService
 */
class CoinsUpdateService
{

    /**
     * * @param EntityManagerInterface $em
     */
    public function __construct(
        private EntityManagerInterface $em
    ) {}


    public function update(CoinsParams $coinsParams,Coin $coin): void
    {
        if($coinsParams->getIsFavorite() !== null){
            $coin->setIsFavorite($coinsParams->getIsFavorite());
        }
        $this->em->persist($coin);
        $this->em->flush($coin);
    }
}