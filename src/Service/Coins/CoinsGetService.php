<?php

namespace App\Service\Coins;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsFilters;

/**
 * Class CoinsGetService
 */
class CoinsGetService 
{
    /**
     * @param CoinRepository $coinRepository
     */
    public function __construct(
        private CoinRepository $coinRepository
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