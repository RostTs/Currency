<?php

namespace App\Service\Coins;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class CoinsGeckoClient
 */
class CoinsGeckoClient 
{
    /**
     * @param FilesystemAdapter $adapter
     * @param HttpClientInterface $coingeckoApiClient
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        private FilesystemAdapter $adapter,
        private HttpClientInterface $coingeckoApiClient,
        private ParameterBagInterface $parameterBag
        ) {}

    /**
     * @return array
     */
    public function getAll():array
    {
        $path = $this->parameterBag->get('coingecko.list');
       
        $coinsJson = $this->coingeckoApiClient->request('GET',$path)->getContent();
        return json_decode($coinsJson);
    }

    /**
     * @param string $ids
     * @param string $currency
     * 
     * @return array
     */
    public function getPrices(string $ids,string $currency): array
    {
        $path = $this->parameterBag->get('coingecko.price');
        $params = '?ids=' . $ids . '&vs_currencies=' . $currency;

        $coinsJson = $this->coingeckoApiClient->request('GET',$path . $params)->getContent();
        return json_decode($coinsJson,1);
    }
}