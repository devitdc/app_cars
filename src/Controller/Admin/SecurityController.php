<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private UserPasswordEncoderInterface $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/client/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            "title" => "Connexion",
            "lastUserName" => $authenticationUtils->getLastUsername(),
            "error" => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/client/sign-up", name="security_signup")
     */
    public function signUp(EntityManagerInterface $entityManager, Request $request, ?Role $role): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $this->userHashPassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $user->setRole($this->getDoctrine()->getRepository(Role::class)->find(2));
            $user->setStatus('active');
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/signup.html.twig', [
            'title' => 'Créer mon compte',
            'formUser' => $form->createView()
        ]);
    }

    public function userHashPassword($user, $plainPassword): string
    {
        return $this->encoder->encodePassword($user, $plainPassword);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
