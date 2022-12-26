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
        $this->page = ($params['page'])??  1;
        $this->pageSize = ($params['pageSize'])??  25;
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

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return ($this->page > 1) ? ($this->page - 1) * $this->pageSize : 0;
    }

}
