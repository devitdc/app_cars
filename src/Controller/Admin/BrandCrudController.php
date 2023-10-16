<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandCrudController extends AbstractController
{
    /**
     * @Route("/admin/brands", name="brand_crud_list")
     */
    public function list(BrandRepository $brandRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $brandNumber = $brandRepository->createQueryBuilder('b')
            ->select('count(b.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $brands = $paginator->paginate(
            $brandRepository->findAllWithPagination(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('brand/list.html.twig', [
            'title' => "Gestion des marques",
            'brands' => $brands,
            'brandNumber' => $brandNumber,
        ]);
    }

    /**
     * @Route("/brand/add", name="brand_crud_add")
     */
    public function add(Request $request, ?Brand $brand, EntityManagerInterface $entityManager): Response
    {
        $brand = new Brand();
        $formAdd = $this->createForm(BrandType::class, $brand);
        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();

            /*return $this->redirectToRoute('brand_crud_edit', [ 'id' => $brand->getId()]);*/
            return $this->redirectToRoute('brand_crud_list');
        }

        return $this->render("brand/crud/add.html.twig", [
            'title' => "Ajout d'une nouvelle marque",
            'brand' => $brand,
            'formAdd' => $formAdd->createView(),
        ]);

    }

    /**
     * @Route("/brand/edit/{id}", name="brand_crud_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, ?Brand $brand): Response
    {
        $formEdit = $this->createForm(BrandType::class, $brand, [
            'action' => $this->generateUrl('brand_crud_edit', ['id' => $brand->getId()])
        ]);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $entityManager->persist($brand);
            $entityManager->flush();
            return $this->redirectToRoute('brand_crud_list');
        }

        return $this->render("brand/crud/edit.html.twig", [
            'title' => "Modification d'une marque",
            'brand' => $brand,
            'formEdit' => $formEdit->createView()
        ]);
    }

    /**
     * @Route("/brand/{id}", name="brand_crud_delete", methods={"DELETE", "POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, Brand $brand)
    {
        if ($this->isCsrfTokenValid("DEL".$brand->getId(), $request->get("_token"))) {
            $entityManager->remove($brand);
            $entityManager->flush();

            return $this->redirectToRoute("brand_crud_list");
        }
    }
}
