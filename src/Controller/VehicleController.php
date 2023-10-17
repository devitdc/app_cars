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

        $vehicleNumber = $vehicleRepository->countVehicles();

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
    public function show(VehicleRepository $vehicleRepository, Vehicle $vehicle): Response
    {
        $car = $vehicleRepository->findVehicle($vehicle);

        if ($car) {
            return $this->render('vehicle/show.html.twig', [
                'vehicle' => $car[0]
            ]);
        }else {
            return $this->redirectToRoute('vehicle_list');
        }
    }
}
