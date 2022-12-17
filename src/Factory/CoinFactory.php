<?php

namespace App\Factory;

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
            'isFavorite' => false,
            'price' => 0,
            'image' => null,
            'created' => new DateTime()
        ];
        $params = array_merge($template, $params);
        $coin = new Coin();
        $coin->setCoingeckoId($params['coinGeckoId'])
             ->setSymbol($params['symbol'])
             ->setName($params['name'])
             ->setIsFavorite($params['isFavorite'])
             ->setPrice($params['price'])
             ->setImage($params['image'])
             ->setCreated($params['created']);

        return $coin;
    }
}