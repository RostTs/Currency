<?php

namespace App\Params;

/**
 * Class CoinsParams
 */
class CoinsParams
{
    protected ?bool $isFavorite = null;

    public function __construct(array $params) 
    {
        $this->isFavorite = ($params['isFavorite'])??  null;
    }


    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }
}