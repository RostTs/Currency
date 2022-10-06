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
        if (array_key_exists('isFavorite',$params)) {
            $this->isFavorite = $params['isFavorite'];
        }
        $this->isFavorite = ($params['isFavorite'])??  false;
        // $this->isFavorite = (isset($params['isFavorite']))? $params['isFavorite'] : $this->isFavorite;
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

    //TODO: make get offet methid

       /**
     * @return int
     */
    // public function make..(): int
    // {
    //     return $this->pageSize;
    // }

}