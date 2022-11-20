<?php

namespace App\Service\Coins;

use Exception;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
/**
 * Class CoinsGeckoClient
 */
class CoinsGeckoClient 
{
    private const SECONDS_TO_SLEEP = 7;
    private const COINS_PER_CHUNK = 200;
    private const SUCCESS_STATUS = 200;

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
     * @param string $coinId
     * 
     * @return array
     */
    public function getSingle(string $coinId):array
    {
        $path = $this->parameterBag->get('coingecko.single') . '/' . $coinId;
        $coinData = $this->coingeckoApiClient->request('GET',$path)->getContent();
        return json_decode($coinData,1);
    }

    /**
     * @param array $ids
     * @param string $currency
     * 
     * @return array
     */
    public function getPrices(array $ids, string $currency): array
    {
        $coins = [];
        $chunks = array_chunk($ids,self::COINS_PER_CHUNK);
        foreach ($chunks as $chunk) {
            $chunkCoins = $this->processChunk($chunk, $currency);
            $coins = array_merge($coins, $chunkCoins);
    
        }
        return $coins;
    }

    private function processChunk(array $chunk,string $currency,bool $wait = false): array {
        
        if($wait){
            sleep(self::SECONDS_TO_SLEEP);
        }
        $idsString = implode(",", $chunk);
        $path = $this->parameterBag->get('coingecko.price');
        $params = '?ids=' . $idsString . '&vs_currencies=' . $currency;
        $coins = $this->coingeckoApiClient->request('GET',$path . $params);

        if($coins->getStatusCode() !== self::SUCCESS_STATUS){
            return $this->processChunk($chunk,$currency,true);
        } else {
            return json_decode($coins->getContent(),true);
        }
    }
}