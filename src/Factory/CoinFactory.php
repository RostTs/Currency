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
            'isFavorite' => 0,
            'price' => null,
            'image' => null,
            'priceUpdated' => (isset($params['price'])) ? new DateTime() : null,
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
             ->setPriceUpdated($params['priceUpdated'])
             ->setCreated($params['created']);

        return $coin;
    }
}