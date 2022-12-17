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
            'coin' => null,
            'price' => 0,
            'updated' => new DateTime()
        ];
        $params = array_merge($template, $params);
        $coin = new CoinArchive();
        $coin->setCoinId($params['coin'])
             ->setPrice($params['price'])
             ->setDate($params['date'])
             ->setUpdated($params['updated']);

        return $coin;
    }
}