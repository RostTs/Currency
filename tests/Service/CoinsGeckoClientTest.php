<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Service\Coins\CoinsGeckoClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

final class CoinsGeckoClientTest extends TestCase {

    private ParameterBagInterface|MockObject $parameterBag;
    private CoinsGeckoClient $coinsGeckoClient;

    private const TOTAL_COINS_PATH = 'https://api.coingecko.com/api/v3/coins/list';
    private const COINS_PRICE_PATH = 'https://api.coingecko.com/api/v3/simple/price';
    private const CURRENCY = 'usd';

    private const LIST_EXPECTED_RESPONSE= [
        ['id' => '01coin','symbol' => 'zoc','name' => '01coin'],
        ['id' => '0-5x-long-algorand-token','symbol' => 'algohalf','name' => '0.5X Long Algorand'],
        ['id' => '0-5x-long-altcoin-index-token','symbol' => 'althalf','name' => '0.5X Long Altcoin Index'],
    ];
        
    private const COINS_IDS = [
        '01coin',
        '0-5x-long-algorand-token',
        '0-5x-long-altcoin-index-token',
        '0-5x-long-ascendex-token-token',
        '0-5x-long-bitcoin-cash-token'
    ];

    private const PRICES_EXPECTED_RESPONSE = [
        '01coin' => [self::CURRENCY => 0.0002356],
        '0-5x-long-algorand-token' => [self::CURRENCY => 9427.01],
        '0-5x-long-altcoin-index-token' => [self::CURRENCY => 15308.0],
        '0-5x-long-ascendex-token-token' => [self::CURRENCY => 5513.0],
        '0-5x-long-bitcoin-cash-token' => [self::CURRENCY => 11490.64]
    ];

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(MockHttpClient::class);
        $this->parameterBag = $this->createMock(ParameterBag::class);
    }

    public function testGetAll()
    {
        $this->createCoinsGecko(self::LIST_EXPECTED_RESPONSE);

        $this->parameterBag
        ->expects($this->once())
        ->method('get')
        ->with('coingecko.list')
        ->willReturn(self::TOTAL_COINS_PATH);

        $coins = $this->coinsGeckoClient->getAll();
        // set json_encode and json_decode in order to convert each element of LIST_EXPECTED_RESPONSE to std object
        $this->assertEquals(json_decode(json_encode(self::LIST_EXPECTED_RESPONSE)), $coins);
    }

    public function testGetPrices()
    {
        $this->createCoinsGecko(self::PRICES_EXPECTED_RESPONSE);

        $this->parameterBag
        ->expects($this->once())
        ->method('get')
        ->with('coingecko.price')
        ->willReturn(self::COINS_PRICE_PATH);

        $coins = $this->coinsGeckoClient->getPrices(self::COINS_IDS, self::CURRENCY);
        $this->assertEquals(self::PRICES_EXPECTED_RESPONSE, $coins);
    }

    private function createCoinsGecko(array $mockResponse) {
        $mockResp = new MockResponse(json_encode($mockResponse));
        $this->coinsGeckoClient = new CoinsGeckoClient(
            new MockHttpClient([$mockResp]),
            $this->parameterBag
        );
    }
}