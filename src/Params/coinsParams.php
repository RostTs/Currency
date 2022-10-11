<?php

namespace App\Params;

use App\Repository\CoinRepository;
use App\Service\Coins\CoinsGeckoClient;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\CoinFactory;

/**
 * Class CoinsParams
 */
class CoinsParams
{
    protected ?bool $isFavorite = null;

    public function __construct(array $params) 
    {
        $this->isFavorite = ($params['isFavorite'])??  null;
    }


    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }
}