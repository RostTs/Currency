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
    private const COINS_PER_CHUNK = 200;
    private const CURRENCY = 'usd';

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

    public function create(?OutputInterface $output)
    {
        $coins = $this->coinsGeckoClient->getAll();
        $progressBar = $output ? new ProgressBar($output, count($coins)) : null;
        $ids = array_column($coins,'id');
        $output ? $progressBar->start() : null;

        $prices = $this->coinsGeckoClient->getPrices($ids,self::CURRENCY);
        $chunks = array_chunk($coins,self::COINS_PER_CHUNK); 

        foreach ($chunks as $chunk) {
            $chunkIds = array_column($chunk,'id');
            
            $result = $this->coinRepository->getByCoingeckoIds($chunkIds);

            foreach($chunk as $singleCoin){
            
                if(!in_array($singleCoin->id,$result)){
                    $coin = $this->coinFactory->createFromArray([
                        'coinGeckoId' => $singleCoin->id,
                        'symbol' => $singleCoin->symbol,
                        'name' => $singleCoin->name,
                        'isFavorite' => false,
                        'price' => ($prices[$singleCoin->id][self::CURRENCY]) ?? 0
                    ]);
                    $this->em->persist($coin);
                }
                $output ? $progressBar->advance() : null;
            }
        }
        $this->em->flush();

        $output ? $progressBar->finish() : null;

    }
}