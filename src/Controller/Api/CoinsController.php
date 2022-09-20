<?php

namespace App\Controller\Api;

use App\Repository\CoinRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Coins\CoinsGetService;
use App\Service\Coins\CoinsFilters;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CoinsController extends AbstractController
{
    /**
     * @Route("/list", name="list",methods="GET")
     * 
     * @param Request $request
     * @param CoinsGetService $getService
     */
    public function getList(Request $request,CoinsGetService $getService, CoinRepository $coinRepository): Response
    {
        $coins = $coinRepository->findAll();

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $defaultContext = [];

        $normalizers = [
            new DateTimeNormalizer($defaultContext),
            new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext),
        ];

//        $encoders = [new JsonEncoder()];

        $serializer = new Serializer($normalizers);



        return new JsonResponse($serializer->normalize($coins, null, ['groups' => 'list']));


       $params = new CoinsFilters($request->query->all());

       return $this->json($getService->getAll($params));
    }
}
