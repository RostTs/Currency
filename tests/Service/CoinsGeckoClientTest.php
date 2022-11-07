<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CoinsGeckoClientTest extends TestCase {

    private HttpClientInterface $httpClient;

    private const TOTAL_COINS_PATH = 'https://api.coingecko.com/api/v3/coins/list';
    private const COINS_PRICE_PATH = 'https://api.coingecko.com/api/v3/simple/price';
    private const COINS_PER_CHUNK = 1;
    private const CURRENCY = 'usd';
    private const SECONDS_TO_SLEEP = 7;
    private const SUCCESS_STATUS = 200;
    private const COINS_IDS = [
        '01coin',
        '0-5x-long-algorand-token',
        '0-5x-long-altcoin-index-token',
        '0-5x-long-ascendex-token-token',
        '0-5x-long-bitcoin-cash-token'
    ];

    public function setUp(): void
    {
        $httpClient = new HttpClient();
        $this->httpClient = $httpClient->create();
    }

    public function testGetAll()
    {
        $httpClient = new HttpClient();
        $coinsJson = $this->httpClient->request('GET',self::TOTAL_COINS_PATH)->getContent();

        // Test if coinsJson is an array
        $this->assertIsArray(json_decode($coinsJson));
    }

    public function testGetPrices()
    {
        $coins = [];
        $chunks = array_chunk(self::COINS_IDS,self::COINS_PER_CHUNK);
        foreach ($chunks as $chunk) {
            $chunkCoins = $this->processChunk($chunk);

            // Test if currency[usd] is float
            $this->assertIsFloat($chunkCoins[$chunk[0]][self::CURRENCY]);

            $coins = array_merge($coins, $chunkCoins);
        }
        // Test if coins is not empty array
        $this->assertIsArray($coins);
        $this->assertNotEmpty($coins);
    }

    private function processChunk(array $chunk,bool $wait = false): array {
        if($wait){
            sleep(self::SECONDS_TO_SLEEP);
        }
        $idsString = implode(",", $chunk);

        $params = '?ids=' . $idsString . '&vs_currencies=' . self::CURRENCY;
        $coins = $this->httpClient->request('GET',self::COINS_PRICE_PATH . $params);

        if($coins->getStatusCode() !== self::SUCCESS_STATUS){
            return $this->processChunk($chunk,true);
        } else {
            return json_decode($coins->getContent(),true);
        }
    }
}