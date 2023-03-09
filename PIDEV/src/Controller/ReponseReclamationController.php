<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use PDO;
use App\Entity\ReponseReclamation;
use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use Symfony\Component\Serializer\SerializerInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReponseReclamationType;
use App\Form\ReponcenewType;
use App\Service\TwilioService;

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
    public function addReponsefromrec(Request $request,$id,EntityManagerInterface $em,TwilioService $twilioService): Response
    {
      
       $ReponseReclamation=new ReponseReclamation();
       $reclamation=$this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);
   

     
     $sql = "SELECT * FROM utilisateur where id=" . 1 .";";
     $stmt = $em->getConnection()->prepare($sql);
     $result = $stmt->execute();
      $row = $result->fetch(PDO::FETCH_ASSOC);


       $form=$this->createForm(ReponcenewType::class,$ReponseReclamation);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        
        $ReponseReclamation->setIdReclamation($reclamation);

        $to = "+216".$row["code"];
                $body = "Hey Mr/Mdme ".$row["nom"]." votre reclamation est traitée";
                $twilioService->sendSms($to, $body);
     
        
        $ReponseReclamation->setDate(new DateTime());
           $em = $this->getDoctrine()->getManager();
           
           $em->persist($ReponseReclamation);
           $em->flush();

           $reclamation->setEtat("traité");
  
           $em->persist($reclamation);
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





































/**
     * @Route("/ReponseReclamationlist",name="ReponseReclamationlist")
     */

     public function getReponseReclamations(SerializerInterface $serializer ){
        $ReponseReclamations = $this->getDoctrine()->getManager()->getRepository(ReponseReclamation::class)->findAll();
      
        $json=$serializer->serialize($ReponseReclamations,'json',['groups'=>'ReponseReclamation']);
        return new Response($json);
    }

    /**
     * @Route("/registerReponseReclamation", name="registerReponseReclamation")
     */
    public function registerReponseReclamation( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $ReponseReclamation = new ReponseReclamation();


        $ReponseReclamation->setSujet($request->query->get("sujet"));
        
        $ReponseReclamation->setEtat($request->query->get("etat"));
        $ReponseReclamation->setDate(new DateTime());


        $reclamation=$this->getDoctrine()->getRepository(Reclamation::class)->findOneBy(array('idRec'=>$request->query->get("id_reclamation")));
        $ReponseReclamation->setIdReclamation($reclamation);
        $manager->persist($ReponseReclamation);
        $manager->flush();
        $json=$serializer->serialize($ReponseReclamation,'json',['groups'=>'ReponseReclamation']);
        return new Response($json);
    }


    
   /**
     * @Route("/updateReponseReclamationjson", name="updateReponseReclamationjson")
     */
    public function updateReponseReclamation( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager)
        {
    $ReponseReclamation = new ReponseReclamation();
    $ReponseReclamation=$this->getDoctrine()->getRepository(ReponseReclamation::class)->findOneBy(array('idReponse'=>$request->query->get("id")));

    $ReponseReclamation->setSujet($request->query->get("sujet"));
        
    $ReponseReclamation->setEtat($request->query->get("etat"));

$entityManager->persist($ReponseReclamation);
$entityManager->flush();

 return new Response("success");

}

/**
* @Route("/deleteReponseReclamatione", name="deleteuere")
*/
public function deleteReponseReclamatione( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager

){

    $ReponseReclamation=$this->getDoctrine()->getRepository(ReponseReclamation::class)->findOneBy(array('idReponse'=>$request->query->get("id")));
    $em=$this->getDoctrine()->getManager();
    $em->remove($ReponseReclamation);
    $em->flush();
    return new Response("success");
   
}

}
