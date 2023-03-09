<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Utilisateur;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


/**
     * @Route("/home", name="home")
     */
    public function index2()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       $user = $this->getUser();
       if($user->getRole()=="ROLE_ADMIN")
       {
        return $this->redirectToRoute('displayusers');
       }
      else if ($user->getRole()=="ROLE_USER")
      {
        $users = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($user->getid());
        
        return $this->render('utilisateur/frontprofil.html.twig', [
            'b'=>$users
        ]);
      }
      else
      {
        return $this->redirectToRoute('app_logout');
      }
     

    }



    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}


