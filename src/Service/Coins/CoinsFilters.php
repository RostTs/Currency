<?php

namespace App\Service\Coins;

class CoinsFilters {
    /** @var int */
    private int $page = 1;

    /** @var int */
    private int $pageSize = 25;

    //---------------------------------------- FILTERS ----------------------------------------
    /** @var bool */
    private bool $isFavorite = false;

    /** 
    * @param array $params
    */
    public function __construct(array $params)
    {
        $this->isFavorite = ($params['isFavorite'])??  false;
        $this->page = ($params['page'])??  false;
        $this->pageSize = ($params['pageSize'])??  false;
    }
    
    /**
     * @return bool|null
     */
    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

        /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    //TODO: make get offet methid

       /**
     * @return int
     */
    // public function make..(): int
    // {
    //     return $this->pageSize;
    // }

}