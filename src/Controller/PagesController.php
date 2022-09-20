<?php

namespace App\Controller;

use App\Repository\CoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache;

class PagesController extends AbstractController
{
    #[Route('/pages', name: 'pages')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PagesController.php',
        ]);
    }

    #[Route('/coins', name: 'coins')]
    public function coins(CoinRepository $coinRepository, Serializer $serializer): Response
    {
        $coins = $coinRepository->findAll();

        return new JsonResponse($serializer->serialize($coins, 'json', ['groups' => 'coin']));



//        $cache = new FilesystemAdapter();
//
//        $cacheItem = $cache->getItem('CoinsList');
//        if(!$cacheItem->isHit()){
//
//            $coins_json = file_get_contents('https://api.coingecko.com/api/v3/coins/list',false);
//            $cacheItem->set($coins_json);
//            $cache->save($cacheItem);
//        }else{
//            $coins_json = $cacheItem->get();
//        }

        return $this->render('/coins.html.twig',[
            'coins' => $coins
        ]);
    }

    #[Route('/',name: 'home')]
    public function home(): Response
    {
      return $this->render('/home.html.twig');
    }
}
