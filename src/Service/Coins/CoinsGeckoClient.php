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
     * @param HttpClientInterface $client
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        private FilesystemAdapter $adapter,
        private HttpClientInterface $client,
        private ParameterBagInterface $parameterBag
        ) {}

    /**
     * @return array
     */
    public function getAll():array
    {
        $path = $this->parameterBag->get('coingecko.list');
        $coinsJson = $this->client->request('GET',$path)->getContent();
        
        return json_decode($coinsJson);
    }
}