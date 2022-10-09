<?php

namespace App\Factory\Coins;

use App\Entity\Coin;
use DateTime;

class CoinFactory {

    /**
     * @param array $params
     *
     * @return Coin
     */
    public function createFromArray(array $params = []): Coin
    {
        $template = [
            'coinGeckoId' => 0,
            'symbol' => null,
            'name' => null,
            'isFavorite' => 0,
            'created' => new DateTime()
        ];
        $params = array_merge($template, $params);

        $coin = new Coin();
        $coin->setCoingeckoId($template['coinGeckoId'])
             ->setSymbol($template['symbol'])
             ->setName($template['name'])
             ->setIsFavorite($template['isFavorite'])
             ->setCreated($template['created']);

        return $coin;
    }
}