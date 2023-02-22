<?php

namespace App\Controller;
use App\Entity\Reclamation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReclamationType;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    /**
     * @Route("/rec", name="displayreclamation")
     */
    public function afficherreclamation(): Response
    {
        $Reclamations= $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('Reclamation/index.html.twig', [
            'b'=>$Reclamations
        ]);
    }

    /**
     * @Route("/addReclamation", name="addReclamation")
     */
    public function addReclamation(Request $request): Response
    {
      
       $Reclamation=new Reclamation();
       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Reclamation->setDate(new DateTime());
           $em = $this->getDoctrine()->getManager();
           $em->persist($Reclamation);
           $em->flush();

           return $this->redirectToRoute('displayreclamation');
       }
       else
       return $this->render('Reclamation/ajouterreclamation.html.twig',['f'=>$form->createView()]);

    }


    
    /**
     * @Route("/addReclamationfront", name="addReclamationfront")
     */
    public function addReclamationfront(Request $request): Response
    {
      
       $Reclamation=new Reclamation();
       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Reclamation->setDate(new DateTime());

           $em = $this->getDoctrine()->getManager();
           $em->persist($Reclamation);
           $em->flush();

           return $this->redirectToRoute('displayreclamation');
       }
       else
       return $this->render('Reclamation/ajouterrecfront.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/modifierecla/{id}", name="modifierRecla")
     */
    public function modifierRecla(Request $request,$id): Response
    {
      
       $Reclamation=$this->getDoctrine()->getManager()->getRepository(reclamation::class)->find($id);
       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayreclamation');
       }
       else
       return $this->render('reclamation/modifier.html.twig',['f'=>$form->createView()]);

    }

    /**
    * @Route("/deleteRecla", name="deleteRecla")
    */
public function deleteReclamation( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager

){

    $reclamation=$this->getDoctrine()->getRepository(Reclamation::class)->findOneBy(array('idRec'=>$request->query->get("idRec")));
    
    $entityManager->remove($reclamation);
    $entityManager->flush();
    $Reclamations= $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('Reclamation/index.html.twig', [
            'b'=>$Reclamations
        ]);
   
}
}
