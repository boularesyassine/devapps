<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Entity\Utilisateur;

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
    public function addReclamation(Request $request,\Swift_Mailer $mailer): Response
    {
      
       $Reclamation=new Reclamation();
       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $message = (new \Swift_Message('Hello new reclamation has been added'))
        ->setFrom('yassine.boulares@esprit.tn')
        ->setTo('yassine.boulares@esprit.tn')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/registration.html.twig',
            ),
            'text/html'
        )

    ;

    $mailer->send($message);
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
































/**
     * @Route("/Reclamationlist",name="Reclamationlist")
     */

     public function getReclamations(SerializerInterface $serializer ){
        $Reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
      
        $json=$serializer->serialize($Reclamations,'json',['groups'=>'Reclamation']);
        return new Response($json);
    }

    /**
     * @Route("/registerReclamation", name="registerReclamation")
     */
    public function registerReclamation( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Reclamation = new Reclamation();


        $Reclamation->setEmail($request->query->get("email"));
        
        $Reclamation->setSujet($request->query->get("sujet"));
        $Reclamation->setDescription($request->query->get("description"));
        $Reclamation->setEtat($request->query->get("etat"));
        $Reclamation->setDate(new DateTime());
        $utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("idUtilisateur")));
        $Reclamation->setIdUtilisateur($utilisateur);
        $manager->persist($Reclamation);
        $manager->flush();
        $json=$serializer->serialize($Reclamation,'json',['groups'=>'Reclamation']);
        return new Response($json);
    }


    
   /**
     * @Route("/updateReclamationjson", name="updateReclamationjson")
     */
    public function updateReclamation( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager)
        {
    $Reclamation = new Reclamation();
    $Reclamation=$this->getDoctrine()->getRepository(Reclamation::class)->findOneBy(array('idRec'=>$request->query->get("id")));


    $Reclamation->setEmail($request->query->get("email"));
        
    $Reclamation->setSujet($request->query->get("sujet"));
    $Reclamation->setDescription($request->query->get("description"));
    $Reclamation->setEtat($request->query->get("etat"));
$entityManager->persist($Reclamation);
$entityManager->flush();

 return new Response("success");

}

/**
* @Route("/deleteReclamatione", name="deleteuere")
*/
public function deleteReclamatione( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager){

    $Reclamation=$this->getDoctrine()->getRepository(Reclamation::class)->findOneBy(array('idRec'=>$request->query->get("id")));
    $em=$this->getDoctrine()->getManager();
    $em->remove($Reclamation);
    $em->flush();
    return new Response("success");
   
}
}
