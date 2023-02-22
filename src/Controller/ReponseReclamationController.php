<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

use App\Entity\ReponseReclamation;
use App\Entity\Reclamation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReponseReclamationType;
use App\Form\ReponcenewType;

class ReponseReclamationController extends AbstractController
{
    #[Route('/reponse/reclamation', name: 'app_reponse_reclamation')]
    public function index(): Response
    {
        return $this->render('reponse_reclamation/index.html.twig', [
            'controller_name' => 'ReponseReclamationController',
        ]);
    }



     /**
     * @Route("/displayReponseReclamation", name="displayReponseReclamation")
     */
    public function afficherReponseReclamations(): Response
    {
        $ReponseReclamations= $this->getDoctrine()->getManager()->getRepository(ReponseReclamation::class)->findAll();
        return $this->render('Reponse_reclamation/index.html.twig', [
            'b'=>$ReponseReclamations
        ]);
    }


   /**
     * @Route("/addReponse", name="addReponse")
     */
    public function addReponseReclamation(Request $request): Response
    {
      
       $ReponseReclamation=new ReponseReclamation();
       $form=$this->createForm(ReponseReclamationType::class,$ReponseReclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $ReponseReclamation->setDate(new DateTime());
           $em = $this->getDoctrine()->getManager();
           
           $em->persist($ReponseReclamation);
           $em->flush();

           return $this->redirectToRoute('displayReponseReclamation');
       }
       else
       return $this->render('Reponse_reclamation/ajouterReponseReclamation.html.twig',['f'=>$form->createView()]);

    }


  /**
     * @Route("/addReponsefromrec/{id}", name="addReponsefromrec")
     */
    public function addReponsefromrec(Request $request,$id): Response
    {
      
       $ReponseReclamation=new ReponseReclamation();
       $reclamation=$this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);

       $form=$this->createForm(ReponcenewType::class,$ReponseReclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $ReponseReclamation->setIdReclamation($reclamation);
        $ReponseReclamation->setDate(new DateTime());
           $em = $this->getDoctrine()->getManager();
           
           $em->persist($ReponseReclamation);
           $em->flush();

           return $this->redirectToRoute('displayReponseReclamation');
       }
       else
       return $this->render('Reponse_reclamation/ajouterReponseRec.html.twig',['f'=>$form->createView()]);

    }


    /**
     * @Route("/modifierReponseReclamation/{id}", name="modifierReponseReclamation")
     */
    public function modifierReponseReclamation(Request $request,$id): Response
    {
      
       $ReponseReclamation=$this->getDoctrine()->getManager()->getRepository(ReponseReclamation::class)->find($id);
       $form=$this->createForm(ReponseReclamationType::class,$ReponseReclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
     
 
       
           $em = $this->getDoctrine()->getManager();
           $em->flush();

           return $this->redirectToRoute('displayReponseReclamation');
       }
       else
       return $this->render('Reponse_reclamation/modifierReponseReclamation.html.twig',['f'=>$form->createView()]);

    }



    /**
* @Route("/deleteReponseReclamation", name="deleteReponseReclamation")
*/
public function deleteReponseReclamation( 
    Request $request,
    
){

$ReponseReclamation=$this->getDoctrine()->getRepository(ReponseReclamation::class)->findOneBy(array('idReponse'=>$request->query->get("id")));
$em=$this->getDoctrine()->getManager();
$em->remove($ReponseReclamation);
$em->flush();
$ReponseReclamations= $this->getDoctrine()->getManager()->getRepository(ReponseReclamation::class)->findAll();
        return $this->render('Reponse_reclamation/index.html.twig', [
            'b'=>$ReponseReclamations
        ]);
}



}
