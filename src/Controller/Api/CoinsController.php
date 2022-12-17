<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Coins\CoinsGetService;
use App\Service\Coins\CoinsFilters;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Coin;
use App\Params\CoinsParams;
use App\Service\Coins\CoinUpdateService;

class CoinsController extends AbstractController
{
    /**
     * @Route("/api/list", name="api_coins_list",methods="GET")
     * 
     * @param Request $request
     * @param CoinsGetService $getService
     */
    public function getList(Request $request,CoinsGetService $getService): Response
    {
       $params = new CoinsFilters($request->query->all());
       return $this->json(
        $getService->getAll($params), 
        Response::HTTP_OK,
        [],
        [ObjectNormalizer::GROUPS => ['list']]
    );
    }

     /**
     * @Route("/api/coin/{coin}", name="api_coin",methods="GET")
     * 
     * @param Request $request
     * @param CoinsGetService $getService
     */
    public function getCoin(Coin $coin, Request $request,CoinsGetService $getService): Response
    {
       $params = new CoinsFilters($request->query->all());
       return $this->json(
        $coin, 
        Response::HTTP_OK,
        [],
        [ObjectNormalizer::GROUPS => ['coin']]
    );
    }

    /**
     * @Route("/api/coin/{coin}", name="api_update_coin",methods="PATCH")
     * 
     * @param Coin $coin
     * @param Request $request
     * @param CoinUpdateService $CoinUpdateService
     */
    public function update(Coin $coin, Request $request,CoinUpdateService $CoinUpdateService): Response
    {
        $params = new CoinsParams(json_decode($request->getContent(), true));
        $CoinUpdateService->update($params,$coin);
        return $this->json(
            $coin, 
            Response::HTTP_OK,
            [],
            [ObjectNormalizer::GROUPS => ['list']]
        );
    }
}
