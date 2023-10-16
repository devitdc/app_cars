<?php

namespace App\Controller;

use App\Entity\SearchVehicle;
use App\Entity\Vehicle;
use App\Form\SearchVehicleType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    /**
     * @Route("/vehicles", name="vehicle_list")
     */
    public function list(VehicleRepository $vehicleRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchVehicle = new SearchVehicle();
        $formSearchVehicle = $this->createForm(SearchVehicleType::class, $searchVehicle);
        $formSearchVehicle->handleRequest($request);

        /**
         * Requête en utilisant le QueryBuilder
         * Compte le nombre total de voiture présent dans l'entité Vehicle
         */
        $vehicleNumber = $vehicleRepository->createQueryBuilder('v')
            ->select('count(v.id)')
            ->getQuery()
            ->getSingleScalarResult();

        /**
         * Requête en utilisant le langage DQL
         * Compte le nombre total de voitures présent dans l'entité Vehicle
         */
        /*$vehicle = $entityManager->createQuery("SELECT COUNT(v) FROM App:Vehicle v")
            ->getSingleScalarResult();*/

        $vehicles = $paginator->paginate(
            $vehicleRepository->findAllWithPagination($searchVehicle),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('vehicle/list.html.twig', [
            'title' => "La vente de voiture avec Titus",
            'vehicles' => $vehicles,
            'vehicleNumber' => $vehicleNumber,
            'formSearchVehicle' => $formSearchVehicle->createView()
        ]);
    }

    /**
     * @Route("/vehicle/{id}", name="vehicle_show")
     */
    public function show(VehicleRepository $vehicleRepository, Vehicle $vehicle)
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicleRepository->find($vehicle)
        ]);
    }
}
