<?php

namespace App\Service\Coins;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Repository\CoinRepository;
use App\Service\Coins\CoinsFilters;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CoinsGetService
 */
class CoinsGetService 
{
    /**
     * @param HttpClientInterface $client
     * @param CoinRepository $coinRepository
     */
    public function __construct(
        private HttpClientInterface $client,
        private CoinRepository $coinRepository,
        private SerializerInterface $serializer
        ) {}

    /**
     * @param CoinsFilters $filters
     * 
     * @return array
     */
    public function getAll(CoinsFilters $filters):array
    {
        $coins = $this->coinRepository->findByExampleField($filters);
        return $coins;
    }
}