<?php

namespace App\Service\Coins;

use Exception;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
/**
 * Class CoinsGeckoClient
 */
class CoinsGeckoClient 
{
    private const SECONDS_TO_SLEEP = 7;
    private const COINS_PER_CHUNK = 200;
    private const SUCCESS_STATUS = 200;
    private const MAX_DAYS = 365;
    public const CURRENCY = 'usd';

    /**
     * @param HttpClientInterface $coingeckoApiClient
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
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
     * 
     * @return array
     */
    public function getPrices(array $ids): array
    {
        $coins = [];
        $chunks = array_chunk($ids,self::COINS_PER_CHUNK);
        foreach ($chunks as $chunk) {
            $chunkCoins = $this->processChunk($chunk, self::CURRENCY);
            $coins[] = $chunkCoins;
        }
        $coins = array_merge([], ...$coins);
        return $coins;
    }

    private function processChunk(array $chunk, bool $wait = false): array {
        if($wait){
            sleep(self::SECONDS_TO_SLEEP);
        }
        $idsString = implode(",", $chunk);
        $path = $this->parameterBag->get('coingecko.price');
        $params = '?ids=' . $idsString . '&vs_currencies=' . self::CURRENCY;
        $coins = $this->coingeckoApiClient->request('GET',$path . $params);

        if($coins->getStatusCode() !== self::SUCCESS_STATUS){
            return $this->processChunk($chunk,true);
        } else {
            return json_decode($coins->getContent(),true);
        }
    }

    /**
     * @param string $coinId
     * 
     * @return array
     */
    public function getSingleCoinPriceHistory(string $coinId):array
    {
        $path = str_replace('*', $coinId, $this->parameterBag->get('coingecko.price.history'));
        $url = $path . '?vs_currency=' . self::CURRENCY . '&days=' . self::MAX_DAYS;
        $coinPrices = $this->coingeckoApiClient->request('GET',$url)->getContent();
        return json_decode($coinPrices, true);
    }

        /**
     * @param string $coinId
     * 
     * @return float
     */
    public function getSingleCoinSimplePrice(string $coinId):float
    {
        return $this->processChunk([$coinId])[$coinId][self::CURRENCY];
    }
}