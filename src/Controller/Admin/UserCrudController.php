<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserAddType;
use App\Form\UserEditType;
use App\Form\UserUpdatePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCrudController extends AbstractController
{
    /**
     * @Route("/admin/users", name="user_crud_list")
     */
    public function list(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $userNumber = $userRepository->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $users = $paginator->paginate(
            $userRepository->findAllWithPagination(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('user/list.html.twig', [
            'title' => 'Gestion des utilisateurs',
            'users' => $users,
            'userNumber' => $userNumber,
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="user_crud_show")
     */
    public function show(UserRepository $userRepository, User $user): Response
    {
        return $this->render("user/show.html.twig", [
            "user" => $userRepository->find($user)
        ]);
    }

    /**
     * @Route("/user/add", name="user_crud_add")
     */
    public function add(Request $request, ?User $user, EntityManagerInterface $entityManager, SecurityController $securityController): Response
    {
        $user = new User();
        $formAdd = $this->createForm(UserAddType::class, $user);

        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $encodedPassword = $securityController->userHashPassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_crud_list');
        }

        return $this->render("user/crud/add.html.twig", [
            'title' => "Ajout d'un nouvel utilisateur",
            'user' => $user,
            'formAdd' => $formAdd->createView(),
        ]);

    }

    /**
     * @Route("/user/edit/{id}", name="user_crud_edit")
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, SecurityController $securityController): Response
    {
        $formEdit = $this->createForm(UserEditType::class, $user, [
            'action' => $this->generateUrl('user_crud_edit', ['id' => $user->getId()])
        ]);
        $formPass = $this->createForm(UserUpdatePasswordType::class, $user, [
            'action' => $this->generateUrl('user_crud_edit', ['id' => $user->getId()])
        ]);

        $formEdit->handleRequest($request);
        $formPass->handleRequest($request);

        if ($formPass->isSubmitted() && $formPass->isValid()) {
            $encodedPassword = $securityController->userHashPassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            //return $this->redirectToRoute('user_list');
        }

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_crud_list');
        }

        return $this->render('user/crud/edit.html.twig', [
            'title' => "Modification d'un utilisateur",
            'user' => $user,
            'editMode' => true,
            'formEdit' => $formEdit->createView(),
            'formPass' => $formPass->createView()
        ]);

    }

    /**
     * @Route("/user/{id}", name="user_crud_delete", methods={"DELETE","POST"})
     */
    public function delete(User $user, EntityManagerInterface $entityManager, Request $request)
    {
        if ($this->isCsrfTokenValid("DEL" . $user->getId(), $request->get("_token"))) {
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->redirectToRoute("user_crud_list");
        }
    }
}
