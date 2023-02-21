<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;


class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }


    /**
     * @Route("/Utilisateurs", name="displayusers")
     */
    public function afficherusers(): Response
    {
        $Utilisateurs= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();
        return $this->render('Utilisateur/index.html.twig', [
            'b'=>$Utilisateurs
        ]);
    }

    /**
     * @Route("/addUtilisateur", name="addUtilisateur")
     */
    public function addUtilisateur(Request $request): Response
    {
      
       $Utilisateur=new Utilisateur();
       $form=$this->createForm(UtilisateurType::class,$Utilisateur);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
       
         $em = $this->getDoctrine()->getManager();
           $em->persist($Utilisateur);
           $em->flush();

           return $this->redirectToRoute('displayusers');
       }
       else
       return $this->render('Utilisateur/createUtilisateur.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/modifierUser/{id}", name="modifierUser")
     */
    public function modifierUser(Request $request,$id): Response
    {
      
       $utilisateur=$this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($id);
       $form=$this->createForm(UtilisateurType::class,$utilisateur);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayusers');
       }
       else
       return $this->render('utilisateur/modifier.html.twig',['f'=>$form->createView()]);

    }

    /**
* @Route("/deleteuser", name="deleteuser")
*/
public function deleteUser( 
    Request $request,
    EntityManagerInterface $entityManager

){

$utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));

$entityManager->remove($utilisateur);
$entityManager->flush();
$Utilisateurs= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();
return $this->render('Utilisateur/index.html.twig', [
    'b'=>$Utilisateurs
]);
}

}








