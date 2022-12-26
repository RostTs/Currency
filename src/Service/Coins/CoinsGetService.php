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
    public function get(CoinsFilters $filters):array
    {
        return $this->coinRepository->findByFilters($filters);
    }

    /**
     * @param CoinsFilters $filters
     * 
     * @return array
     */
    public function getAll(CoinsFilters $filters):array
    {
        return $this->coinRepository->findByFilters($filters);
    }

    /**
     * @param CoinsFilters $filters
     *
     * @return string
     */
    public function getRange(CoinsFilters $filters): string
    {
        $total = $this->coinRepository->getTotalResultsByFilters($filters);

        $offset = $filters->getOffset();
        $lastRecord = ($total > $offset + $filters->getPageSize())? $offset + $filters->getPageSize(): $total;
        return "coins=$offset-$lastRecord/$total";
    }
}
