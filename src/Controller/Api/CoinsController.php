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
use App\Service\Coins\CoinsUpdateService;

class CoinsController extends AbstractController
{
    /**
     * @Route("/list", name="list",methods="GET")
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
     * @Route("/coin/{coin}", name="list",methods="PATCH")
     * 
     * @param Coin $coin
     * @param Request $request
     * @param CoinsUpdateService $coinsUpdateService
     */
    public function update(Coin $coin, Request $request,CoinsUpdateService $coinsUpdateService): Response
    {
        $params = new CoinsParams($request->query->all());
        $coinsUpdateService->update($params,$coin);
        return $this->json(
            $coin, 
            Response::HTTP_OK,
            [],
            [ObjectNormalizer::GROUPS => ['list']]
        );
    }
}
