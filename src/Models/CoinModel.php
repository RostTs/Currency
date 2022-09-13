<?php

namespace App\Models\Coin;

use App\Entity\Coin;
use DateTime;

/**
 * Class CoinModel
 */
class CoinModel 
{
    /** @var string */
    private $coinId;

    /** @var string */
    private $symbol;

    /** @var string */
    private $name;

    /** @var bool */
    private $isFavorite;

    /** @var DateTime */
    private $created;

    /**
     * @param Coin $coin
     */
    public function __construct(Coin $coin)
    {
        $this->coinId = $coin->getCoingeckoId();
        $this->symbol = $coin->getSymbol();
        $this->name = $coin->getName();
        $this->created = $coin->getCreated();
    }

    
    public function getCoinId(): string
    {
        return $this->coinId;
    }


    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getIsFavorite(): bool
    {
        return $this->isFavorite;
    }


    /**
     * @param string $coinId
     */
    public function setCoinId(string $coinId): void
    {
        $this->coinId = $coinId;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @param bool $isFavorite
     */
    public function setIsFavorite(bool $isFavorite): void
    {
        $this->isFavorite = $isFavorite;
    }

    
    public function toArray(): array
    {
        return [
            'coingeckoId' => $this->coinId,
            'symbol' => $this->symbol,
            'name' => $this->name,
            'created' => $this->created->format('Y-m-d'),
            'isFavorite' => (bool) $this->isFavorite
        ];
    }
}