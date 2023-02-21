<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Entity\ReponseOffre;
use App\Form\ReponsenewFormType;
use App\Form\ReponseOffreType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ReponseOffreController extends AbstractController
{
    #[Route('/reponse/offre', name: 'app_reponse_offre')]
    public function index(): Response
    {
        return $this->render('reponse_offre/index.html.twig', [
            'controller_name' => 'ReponseOffreController',
        ]);
    }



    

    /**
     * @Route("/afficherReponseOffre", name="afficherReponseOffre")
     */
    public function afficherReponseOffre(EntityManagerInterface $em): Response
    {
        $Reponse= $em->getRepository(ReponseOffre::class)->findAll();
        return $this->render('reponse_offre/index.html.twig', [
            'reponse'=>$Reponse
        ]);
    }







    /**
     * @Route("/addReponse", name="addReponse")
     */
    public function addReponse(Request $request,EntityManagerInterface $EM): Response
    {
      
       $Reponse=new ReponseOffre();
       $form=$this->createForm(ReponseOffreType::class,$Reponse);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Reponse->setDate(new DateTime());

           $EM->persist($Reponse);
           $EM->flush();

           return $this->redirectToRoute('afficherReponseOffre');
       }
       else
       return $this->render('reponse_offre/ajouterReponse.html.twig',['f'=>$form->createView()]);

    }


   /**
     * @Route("/addReponseforoffre/{id}", name="addReponseforoffre")
     */
    public function addReponseforoffre(Request $request,EntityManagerInterface $EM,$id): Response
    {
        $offre=$EM->getRepository(AppelOffre::class)->find($id);

       $Reponse=new ReponseOffre();
       $form=$this->createForm( ReponsenewFormType::class,$Reponse);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Reponse->setDate(new DateTime());
        $Reponse->setIdOffre($offre);
           $EM->persist($Reponse);
           $EM->flush();

           return $this->redirectToRoute('afficherReponseOffre');
       }
       else
       return $this->render('reponse_offre/ajouterReponseforoffre.html.twig',['f'=>$form->createView()]);

    }



    /**
     * @Route("/modifierReponse/{id}", name="modifierReponse")
     */
    public function modifierReponse(Request $request,$id,EntityManagerInterface $EM): Response
    {
      
       $Reponse=$EM->getRepository(ReponseOffre::class)->find($id);
       $form=$this->createForm(ReponseOffreType::class,$Reponse);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           
           $EM->flush();

           return $this->redirectToRoute('afficherReponseOffre');
       }
       else
       return $this->render('reponse_offre/modifierReponse.html.twig',['f'=>$form->createView()]);

    }



    /**
* @Route("/deleteReponse", name="deleteReponse")
*/
public function deleteReponse( 
    Request $request,EntityManagerInterface $EM
    
){

$Reponse=$EM->getRepository(ReponseOffre::class)->findOneBy(array('id'=>$request->query->get("id")));
$EM->remove($Reponse);
$EM->flush();
return new Response("success");

}
}
