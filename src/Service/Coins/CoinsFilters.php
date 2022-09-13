<?php

namespace App\Service\Coins;

class CoinsFilters {
    /** @var int */
    private $page = 1;

    /** @var int */
    private $pageSize = 25;

    //---------------------------------------- FILTERS ----------------------------------------
    /** @var bool|null */
    private $isFavorite = null;

    /** 
    * @param array $params
    */
    public function __construct(array $params)
    {
        $this->isFavorite = (isset($params['isFavorite']))? $params['isFavorite'] : null;
        $this->page = (isset($params['page']))? $params['isFavorite'] : null;
        $this->pageSize = (isset($params['pageSize']))? $params['isFavorite'] : null;
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

}