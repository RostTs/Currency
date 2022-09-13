<?php

namespace App\Service\Coins;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Repository\CoinRepository;
use App\Models\Coin\CoinModel;
use App\Service\Coins\CoinsFilters;

/**
 * Class CoinsGetService
 */
class CoinsGetService 
{
    /** @var HttpClientInterface */
    private $client;

    /** @var CoinRepository */
    private $coinRepository;

    /**
     * @param HttpClientInterface $client
     * @param CoinRepository $coinRepository
     */
    public function __construct(HttpClientInterface $coingeckoApiClient,CoinRepository $coinRepository)
    {
        $this->client = $coingeckoApiClient;
        $this->coinRepository = $coinRepository;
    }

    /**
     * @param CoinsFilters $filters
     * 
     * @return array
     */
    public function getAll(CoinsFilters $filters):array
    {
        $coinsArray = [];
        $coins = $this->coinRepository->findAll();

        foreach($coins as $coin){
            $coinModel = new CoinModel($coin);
            $coinsArray[] = $coinModel->toArray();
        }
        return $coinsArray;
    }
}