<?php

namespace App\Factory;

use App\Entity\CoinArchive;
use DateTime;

class CoinArchiveFactory {

    /**
     * @param array $params
     *
     * @return CoinArchive
     */
    public function createFromArray(array $params = []): CoinArchive
    {
        $template = [
            'coinId' => null,
            'price' => 0,
            'updated' => new DateTime()
        ];
        $params = array_merge($template, $params);
        $coin = new CoinArchive();
        $coin->setCoinId($params['coinId'])
             ->setPrice($params['price'])
             ->setUpdated($params['updated']);

        return $coin;
    }
}