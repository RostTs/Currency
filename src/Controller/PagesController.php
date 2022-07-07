<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Routing\Annotation\Route;
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
    public function coins(): Response
    {
        $cache = new FilesystemAdapter();

        $cacheItem = $cache->getItem('CoinsList');
        if(!$cacheItem->isHit()){
              
            $coins_json = file_get_contents('https://api.coingecko.com/api/v3/coins/list',false);
            $cacheItem->set($coins_json);
            $cache->save($cacheItem);
        }else{
            $coins_json = $cacheItem->get();
        }

        return $this->render('/coins.html.twig',[
            'coins' => json_decode($coins_json)
        ]);
    }

    #[Route('/',name: 'home')]
    public function home(): Response
    {
      return $this->render('/home.html.twig');
    }
}
