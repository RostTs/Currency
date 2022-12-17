<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsGeckoClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use App\Factory\CoinFactory;

/**
 * Class CoinsCreateService
 */
class CoinsCreateService 
{
    private const COINS_PER_CHUNK = 200;
    private const PROGRESS_MESSAGE = 'Configuring coins';
    
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

    public function create(?OutputInterface $output): void
    {
        $coins = $this->coinsGeckoClient->getAll();
        $progressBar = $output ? new ProgressBar($output, count($coins)) : null;
        $ids = array_column($coins,'id');
        $progressBar->start();

        $prices = $this->coinsGeckoClient->getPrices($ids);
        $chunks = array_chunk($coins,self::COINS_PER_CHUNK); 

        foreach ($chunks as $chunk) {
            $chunkIds = array_column($chunk,'id');
            
            $result = $this->coinRepository->getByCoingeckoIds($chunkIds);

            foreach($chunk as $singleCoin){
                $coinPrice = ($prices[$singleCoin->id][$this->coinsGeckoClient::CURRENCY]) ?? 0;
                if(!in_array($singleCoin->id,$result)){
                    $coin = $this->coinFactory->createFromArray([
                        'coinGeckoId' => $singleCoin->id,
                        'symbol' => $singleCoin->symbol,
                        'name' => $singleCoin->name,
                        'isFavorite' => false,
                        'price' => $coinPrice
                    ]);
                } else {
                    $coin = $this->coinRepository->getByCoingeckoId($singleCoin->id);
                    $coin->setPrice($coinPrice);
                }
                $this->em->persist($coin);

                $progressBar?->advance();
            }
        }
        $this->em->flush();

        $progressBar?->finish();

    }

    public function createForList(?OutputInterface $output, array $list): void
    {
        $progressBar = $output ? new ProgressBar($output, count($list)) : null;
        $progressBar?->setMessage(self::PROGRESS_MESSAGE);
        $progressBar?->start();
            foreach($list as $coin) {
                $coinData = $this->coinsGeckoClient->getSingle($coin);
                $coin = $this->coinRepository->getByCoingeckoId($coinData['id']);
                if (!$coin) {
                    $coin = $this->coinFactory->createFromArray([
                        'coinGeckoId' => $coinData['id'],
                        'symbol' => $coinData['symbol'],
                        'name' => $coinData['name'],
                        'isFavorite' => false,
                        'image' => $coinData['image']['thumb'],
                        'price' => $coinData['market_data']['current_price'][$this->coinsGeckoClient::CURRENCY]
                    ]);
                } else {
                    $coin->setPrice($coinData['market_data']['current_price'][$this->coinsGeckoClient::CURRENCY]);
                }
                $this->em->persist($coin);
                $progressBar?->advance();
            }
        $this->em->flush();
        $progressBar?->finish();

    }
}