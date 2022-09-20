<?php

namespace App\Service\Coins;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CoinsParseService
 */
class CoinsParseService 
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

    /**
     * @return array
     */
    public function parseAll():array
    {
        $path = '/api/v3/coins/list';
        
        return $this->client->request('GET',$path)->toArray();
    }
}
