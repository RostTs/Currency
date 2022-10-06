<?php

namespace App\Service\Coins;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CoinsGeckoClient
 */
class CoinsGeckoClient 
{
    /** @var FilesystemAdapter */
    private $adapter;

    /** @var HttpClientInterface */
    private $client;

    /**
     * @param FilesystemAdapter $adapter
     * @param HttpClientInterface $client
     */
    public function __construct(FilesystemAdapter $adapter,HttpClientInterface $coingeckoApiClient)
    {
        $this->adapter = $adapter;
        $this->client = $coingeckoApiClient;
    }

    //TODO: move str to .env
    /**
     * @return array
     */
    public function getAll():array
    {
        $path = '/api/v3/coins/list';
        $coinsJson = $this->client->request('GET',$path)->getContent();
        
        return json_decode($coinsJson);
    }
}