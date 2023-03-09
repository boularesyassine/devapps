<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Entity\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReclamationType;
use App\Form\SearchFormType;

use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use PDO;

class ReclamationController extends AbstractController
{
     /**
     * @Route("/recTEST", name="TEST")
     */
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
        $form=$this->createForm(SearchFormType::class);

        $Reclamations= $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('Reclamation/index.html.twig', [
            'b'=>$Reclamations,
            'f'=>$form->createView()
        ]);
    }









    /**
     * @Route("/statstiquerec", name="statstiquerec")
     */
    public function statistiques(EntityManagerInterface $em){
        $dates = [];
        $produitCount = [];
        $categColor = [];
       
        $sql = "SELECT EXTRACT(year FROM date) AS year , COUNT(id_rec) as t FROM reclamation GROUP BY year;";
        $stmt = $em->getConnection()->prepare($sql);
   
        $result = $stmt->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $dates[] = $row["year"];
            $produitCount[] = $row["t"];
        }
    
        // On va chercher toutes les catégories
   
       
      
  
  
        return $this->render('reclamation/stat.html.twig', [
            'dates' => json_encode($dates),
            'produitCount' => json_encode($produitCount),
        ]);
  
  
    }





    /**
     * @Route("/addReclamation", name="addReclamation")
     */
    public function addReclamation(Request $request,\Swift_Mailer $mailer,EntityManagerInterface $em): Response
    {
      
       $Reclamation=new Reclamation();
     

       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $form->handleRequest($request);
       
 
       if($form->isSubmitted() && $form->isValid()){
        $Reclamation->setEtat("en cours");
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $Reclamation->setIdUtilisateur($user);
  
        $message = (new \Swift_Message('Hello new reclamation has been added  please wait from the response'))
        ->setFrom('yassine.boulares@esprit.tn')
        ->setTo('yassine.boulares@esprit.tn')
        ->setBody(" Hello new reclamation has been added  please wait from the response")

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
    public function addReclamationfrontS(Request $request): Response
    {
      $user = $this->get('security.token_storage')->getToken()->getUser();
       $Reclamation=new Reclamation();
       $form=$this->createForm(ReclamationType::class,$Reclamation);
       $Reclamation->setIdUtilisateur($user);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Reclamation->setDate(new DateTime());
        $Reclamation->setEtat("en cours");

           $em = $this->getDoctrine()->getManager();
           $em->persist($Reclamation);
           $em->flush();

           return $this->redirectToRoute('home');
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
    return $this->redirectToRoute('displayreclamation');

   
}


/**
 * @Route("/search", name="searchedrec")
 */
public function search(Request $request,SerializerInterface $serializer)
{
    $em = $this->getDoctrine()->getManager();
    $bacRepository = $em->getRepository(Reclamation::class);
  // deserialize the form data into an array
  $search = $request->query->get('search_form');
  $query= $search["searchQuery"];
  $sort = $search["orderby"];
  // retrieve the search query from the 'query' attribute
    $queryBuilder = $bacRepository->createQueryBuilder('b');
    
    $search = $request->query->get('searchQuery');
   

    
    
        $queryBuilder->where('b.sujet LIKE :search OR b.email LIKE :search OR b.description LIKE :search OR b.etat LIKE :search OR b.date LIKE :search')
                     ->setParameter('search', "%$query%");
    
    
    if ($sort ) {
        $queryBuilder->orderBy("b.$sort","ASC");
    }
    
    $result = $queryBuilder->getQuery()->getResult();
    $json=$serializer->serialize($result,'json',['groups'=>'bac']);
   
    
    return $this->json([
        'results' => $this->renderView('reclamation/result.html.twig', [
            'b' => $result,
           
            
        ]),
    
       
    ]);
}







/**
 * @Route("/searched", name="search")
 */
public function searched(Request $request,SerializerInterface $serializer)
{
    $em = $this->getDoctrine()->getManager();
    $bacRepository = $em->getRepository(Reclamation::class);
  
  // retrieve the search query from the 'query' attribute
    $queryBuilder = $bacRepository->createQueryBuilder('b');
    
    $query = $request->query->get('search');
   

    
    
        $queryBuilder->where('b.sujet LIKE :search OR b.email LIKE :search OR b.description LIKE :search OR b.etat LIKE :search OR b.date LIKE :search')
                     ->setParameter('search', "%$query%");
    
    
   
    
    $result = $queryBuilder->getQuery()->getResult();
    $json=$serializer->serialize($result,'json',['groups'=>'Reclamation']);
   
    
    return new Response($json);
}





                             /**
                            * @Route("/deleteReclamatione", name="deleteuereee")
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

                   
}
