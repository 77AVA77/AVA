<?php

namespace App\Controller;

use App\Entity\Country;
use App\Service\ApiService;
use App\Service\IndexService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public EntityManagerInterface $em;

    public IndexService $indexService;

    public ApiService $apiService;

    public function __construct(EntityManagerInterface $em, IndexService $indexService, ApiService $apiService)
    {
        $this->em = $em;
        $this->indexService = $indexService;
        $this->apiService = $apiService;
    }

    #[Route('/', name: 'index', defaults: ['country' => 'en'])]
    public function indexPage($country){
        return $this->redirectToRoute('country_index', ["country"=>$country]);
    }

    #[Route('/{country}', name: 'country_index')]
    public function countryPage($country, Request $request){
        $baseUrl = $request->getSchemeAndHttpHost();

        $qb = $this->em->createQueryBuilder();
        $countries = $qb->select('c')
            ->from(Country::class, 'c')
            ->orderBy('c.id', 'ASC')
            ->getQuery()->getArrayResult();
//        $weatherData = $this->apiService->getWeatherApi();
//        dd($weatherData);
        $params = [
            "countries" => $countries,
            "weather" => 1,
            "baseUrl" => $baseUrl
        ];
        return $this->render('main.html.twig', $params);
    }
}