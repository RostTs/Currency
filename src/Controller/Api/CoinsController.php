<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Coins\CoinsGetService;
use App\Service\Coins\CoinsFilters;

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
       return $this->json($getService->getAll($params));
    }
}
