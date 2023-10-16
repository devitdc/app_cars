<?php

namespace App\Controller\Admin;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelCrudController extends AbstractController
{
    /**
     * @Route("/admin/models", name="model_crud_list")
     */
    public function list(ModelRepository $modelRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $modelNumber = $modelRepository->createQueryBuilder('m')
            ->select('count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $models = $paginator->paginate(
            $modelRepository->findAllWithPagination(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('model/list.html.twig', [
            'title' => "Gestion des modèles",
            'models' => $models,
            'modelNumber' => $modelNumber,
        ]);
    }

    /**
     * @Route("/model/add", name="model_crud_add")
     */
    public function add(Request $request, ?Model $model, EntityManagerInterface $entityManager): Response
    {
        $model = new Model();
        $formAdd = $this->createForm(ModelType::class, $model);
        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $entityManager->persist($model);
            $entityManager->flush();

            /*return $this->redirectToRoute('brand_crud_edit', [ 'id' => $brand->getId()]);*/
            return $this->redirectToRoute('model_crud_list');
        }

        return $this->render("model/crud/add.html.twig", [
            'title' => "Ajout d'un modèle",
            'model' => $model,
            'formAdd' => $formAdd->createView(),
        ]);

    }

    /**
     * @Route("/model/edit/{id}", name="model_crud_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, ?Model $model): Response
    {
        $formEdit = $this->createForm(ModelType::class, $model, [
            'action' => $this->generateUrl('model_crud_edit', ['id' => $model->getId()])
        ]);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $entityManager->persist($model);
            $entityManager->flush();
            return $this->redirectToRoute('model_crud_list');
        }

        return $this->render("model/crud/edit.html.twig", [
            'title' => "Modification d'un modèle",
            'model' => $model,
            'formEdit' => $formEdit->createView()
        ]);
    }

    /**
     * @Route("/model/{id}", name="model_crud_delete", methods={"DELETE", "POST"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, Model $model)
    {
        if ($this->isCsrfTokenValid("DEL".$model->getId(), $request->get("_token"))) {
            $entityManager->remove($model);
            $entityManager->flush();

            return $this->redirectToRoute("model_crud_list");
        }
    }
}
