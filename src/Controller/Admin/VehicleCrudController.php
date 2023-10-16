<?php

namespace App\Controller\Admin;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleCrudController extends AbstractController
{
    /**
     * @Route("/vehicle/add", name="vehicle_crud_add")
     */
    public function add(Request $request, ?Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $formAdd = $this->createForm(VehicleType::class, $vehicle);
        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('vehicle_crud_edit', [ 'id' => $vehicle->getId()]);
        }

        return $this->render("vehicle/crud/add.html.twig", [
            'title' => "Ajout d'une nouvelle voiture",
            'vehicle' => $vehicle,
            'formAdd' => $formAdd->createView(),
        ]);

    }

    /**
     * @Route("/vehicle/edit/{id}", name="vehicle_crud_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, ?Vehicle $vehicle): Response
    {
        /*if (preg_match('/vehicle\/edit\/[0-9]+/', $_SERVER['PATH_INFO'])){
            return $this->redirectToRoute('vehicle_list');
        } else {*/

            $formEdit = $this->createForm(VehicleType::class, $vehicle, [
                'action' => $this->generateUrl('vehicle_crud_edit', ['id' => $vehicle->getId()])
            ]);
            $formEdit->handleRequest($request);

            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $entityManager->persist($vehicle);
                $entityManager->flush();
                return $this->redirectToRoute('vehicle_list');
            }

            return $this->render("vehicle/crud/edit.html.twig", [
                'title' => "Modification d'une voiture",
                'vehicle' => $vehicle,
                'formEdit' => $formEdit->createView()
            ]);
        /*}*/

    }

    /**
     * @Route("/vehicle/{id}", name="vehicle_crud_delete", methods={"DELETE", "POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, Vehicle $vehicle)
    {
        if ($this->isCsrfTokenValid("DEL".$vehicle->getId(), $request->get("_token"))) {
            $entityManager->remove($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute("vehicle_list");
        }
    }
}
