<?php

namespace App\Controller;

use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/quack", name="app_api", methods={"GET"})
     */

    public function index(QuackRepository $quackRepository, SerializerInterface $normalizer): Response
    {
        $quacks = $quackRepository->findAll();
        $quackNormalises = $normalizer->normalize($quacks, null,['groups'=>'quack:all']);//transforme l'objet quack en tableau de donnée

        $json = json_encode($quackNormalises);
        $response = new Response($json, 200, [
            "Content-type"=> "application/json"
        ]);
        return $response;
//        //ou

//        return $this->json($quackRepository->findAll(),200,[],['groups'=>'quack:read']) ;
    }
//    public function displayby(QuackRepository $quackRepository, NormalizerInterface $normalizer): Response
//    {
//        $quacks = $quackRepository->findAll();
//        $quackNormalises = $normalizer->normalize($quacks, null,['groups'=>'quack:read']);//transforme l'objet quack en tableau de donnée
//
//        $json = json_encode($quackNormalises);
//        $response = new Response($json, 200, [
//            "Content-type"=> "application/json"
//        ]);
//        return $response;
//    }
}
