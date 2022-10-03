<?php

namespace App\Service\Coins;

class CoinsFilters {
    /** @var int */
    private $page = 1;

    /** @var int */
    private $pageSize = 25;

    //---------------------------------------- FILTERS ----------------------------------------
    /** @var bool */
    private $isFavorite = false;

    /** 
    * @param array $params
    */
    public function __construct(array $params)
    {
        $this->isFavorite = (isset($params['isFavorite']))? $params['isFavorite'] : $this->isFavorite;
        $this->page = (isset($params['page']))? $params['page'] : $this->page;
        $this->pageSize = (isset($params['pageSize']))? $params['pageSize'] : $this->pageSize;
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