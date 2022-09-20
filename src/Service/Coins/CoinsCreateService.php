<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsParseService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coin;
use DateTime;

/**
 * Class CoinsCreateService
 */
class CoinsCreateService 
{
    /** @var CoinsParseService */
    private $coinsParseService;

    /** @var CoinRepository */
    private $coinRepository;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param CoinsParseService $coinsParseService
     * @param CoinRepository $coinRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        CoinsParseService $coinsParseService,
        CoinRepository $coinRepository,
        EntityManagerInterface $em
        )
    {
        $this->coinsParseService = $coinsParseService;
        $this->coinRepository = $coinRepository;
        $this->em = $em;
    }

    public function create(): void
    {
        $parsedCoins = $this->coinsParseService->parseAll();

        foreach($parsedCoins as $parsedCoin){
            if(!$this->coinRepository->findOneBy(['coingeckoId' => $parsedCoin->id])){
                $coin = new Coin();
                $coin->setCoingeckoId($parsedCoin->id);
                $coin->setSymbol($parsedCoin->symbol);
                $coin->setName($parsedCoin->name);
                $coin->setIsFavorite(false);
                $coin->setCreated(new DateTime());

                $this->em->persist($coin);
                $this->em->flush();
            }
        }
    }
}
