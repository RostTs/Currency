<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoinsController extends AbstractController
{
    #[Route('/list',name:'list')]
    public function getList(): Response
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

       return $this->json([
           'data' => $coins_json ,
           'path' => 'src/Controller/CoinsController.php',
       ]);
    }
}
