<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_index")
     */
    public function index(VehicleRepository $vehicleRepository): Response
    {
        $vehicleNumber = $vehicleRepository->createQueryBuilder('v')
            ->select('count(v.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $currentlyVehicle = $vehicleRepository->createQueryBuilder('v')
            ->setMaxResults(5)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult();

        $lastId = $vehicleRepository->createQueryBuilder('v')
            ->select('v.id')
            ->setMaxResults(1)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('main/index.html.twig', [
            'title' => "Titus vente véhicules de collection, sport et prestige",
            'vehicleNumber' => $vehicleNumber,
            'currentlyVehicle' => $currentlyVehicle,
            'lastId' => $lastId
        ]);
    }
}
