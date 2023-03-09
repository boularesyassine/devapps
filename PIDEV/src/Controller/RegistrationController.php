<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur(); // instance du class user
        $role='ROLE_USER'; // varibale feha array 'ROLE_USER'
        $form = $this->createForm(UtilisateurType::class, $user); //creation du formulaire en s'adaptand lil utilisateur type ( fichier du formulaire = 9aleb) les info li inputed fil form ils vons etre stocker dans l'instance
        $form->handleRequest($request); // preparation du requet sql 

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                /** @var UploadedFile $file */
            $file = $form->get('photo')->getData();
           $filename=md5(uniqid()).'.'.$file->guessExtension(); 
           $file->move(
            $this->getParameter('Images_directory'),
            $filename
            
        );
        $user->setPhoto($filename);
        // stockage du path d'image selectionner dans la  bd 
            $user->setRoles($role);

            $entityManager->persist($user);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);

        
    }
}