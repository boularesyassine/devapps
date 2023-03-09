<?php

namespace App\Controller;
use App\Entity\Publicite;
use PDO;
use App\Entity\Rating;
use App\Entity\Sponsor;
use App\Entity\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface ;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PubliciteType;
use App\Form\UpdatepubliciteType;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\TwilioService;
class PubliciteController extends AbstractController
{
    #[Route('/', name: 'app_publicite')]
    public function index(EntityManagerInterface $em): Response
    {
        $users= $em->getRepository(Publicite::class)->findAll();
        return $this->render('basefront.html.twig', [
            'b'=>$users
        ]);
    }
    /**
     * @Route("/ee", name="displaypub")
     */
    public function afficherpublicites(EntityManagerInterface $em): Response
    {
        $publicites= $em->getRepository(Publicite::class)->findAll();
        return $this->render('publicite/index.html.twig', [
            'b'=>$publicites
        ]);
    }




 /**
     * @Route("/showrand", name="showrand")
     */
    public function showrand(EntityManagerInterface $em): Response
    {
        $sql = "SELECT * FROM publicite ORDER BY RAND() LIMIT 1";
            $stmt = $em->getConnection()->prepare($sql);
            $result = $stmt->execute();
            $values = $result->fetch(PDO::FETCH_ASSOC);
            $publicite = new Publicite();
            $publicite->setId($values['id']);
            $publicite->setNomPub($values['nom_pub']);
            $publicite->setDescription($values['description']);
            $publicite->setImage($values['image']);

        return $this->render('publicite/showrandpub.html.twig', [
            'b'=>$publicite
        ]);
    }


      /**
     * @Route("/rate", name="rating")
     */
    public function rate(Request $request,EntityManagerInterface $entityManagerInterface,SerializerInterface $serializer): Response
    {
       $rate=new Rating();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $pub=$entityManagerInterface->getRepository(Publicite::class)->findOneBy(array('id'=>$request->query->get("idpub")));

            $rate->setRate($request->query->get("rate"));
            $rate->setIduser($user);
            $rate->setIdpub($pub);
           $entityManagerInterface->persist($rate);
           $entityManagerInterface->flush();
           $json= new JsonResponse();
   
    
           return $json;
   }
       

 


    /**
     * @Route("/addpublicite", name="addpub")
     */
    public function addpublicite(Request $request,EntityManagerInterface $entityManagerInterface,TwilioService $twilioService): Response
    {
       $publicite=new publicite();
       $form=$this->createForm(PubliciteType::class,$publicite);
       $form->handleRequest($request);
       $sql = "SELECT * FROM utilisateur where id=" . 1 .";";
       $stmt = $entityManagerInterface->getConnection()->prepare($sql);
       $result = $stmt->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
       if($form->isSubmitted() && $form->isValid()){


        /** @var UploadedFile $file */
        $file = $form->get('image')->getData();
        $filename=md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
         $this->getParameter('Images_directory'),
         $filename
         
     );
     $to = "+216".$row["code"];
     $body = "Hey Mr/Mdme ".$row["nom"]." une publicite est ajouter par un administrateur";
     $twilioService->sendSms($to, $body);

            $publicite->setImage($filename);
           $entityManagerInterface->persist($publicite);
           $entityManagerInterface->flush();

           return $this->redirectToRoute('displaypub');
       }
       else
       return $this->render('publicite/ajouterpublicite.html.twig',['f'=>$form->createView()]);

    }


    /**
     * @Route("/modifierpublicite/{id}", name="modifierpublicite")
     */
    public function modifierEvent(Request $request,EntityManagerInterface $em,$id): Response
    {
      
       $publicite=$em->getRepository(Publicite::class)->find($id);
       $form=$this->createForm(UpdatepubliciteType::class,$publicite);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){           
           $em->flush();

           return $this->redirectToRoute('displaypub');
       }
       else
       return $this->render('publicite/modifierpublicite.html.twig',['f'=>$form->createView()]);

    }


    /**
* @Route("/deletePublicite", name="deletePublicite")
*/
public function deletePublicite( 
    Request $request,
    EntityManagerInterface $entityManager

){

$Publicite=$entityManager->getRepository(Publicite::class)->findOneBy(array('id'=>$request->query->get("id")));
$entityManager->remove($Publicite);
$entityManager->flush();
//return new Response("success");

$Publicite= $entityManager->getRepository(Publicite::class)->findAll();
return $this->render('publicite/index.html.twig', [
    'b'=>$Publicite
]);

}





/**
     * @Route("/statspub", name="statspub")
     */
    public function statistiques(EntityManagerInterface $em){
        $dates = [];
        $produitCount = [];
        $categColor = [];
       
        $sql = "SELECT nom_pub , id FROM publicite";
        $stmt = $em->getConnection()->prepare($sql);
        $result = $stmt->execute();



        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $dates[] = $row["nom_pub"];
            $produitCount[] = $row["id"];
            $sql2 = "SELECT SUM(rate)  as rate from rating where idpub=".strval($row["id"]) ;
             $stmt2 = $em->getConnection()->prepare($sql2);
            $result2 = $stmt2->execute();
            $row2 = $result2->fetch(PDO::FETCH_ASSOC);
            if($row2["rate"]==null)
            {
                $categColor[]=0;
            }
            else
            $categColor[] = $row2["rate"];
 
        }
    
        // On va chercher toutes les catégories
   
       
      
  
  
        return $this->render('publicite/stat.html.twig', [
            'dates' => json_encode($dates),
            'produitCount' => json_encode($categColor),
        ]);
  
  
    }








/**
 * @Route("/searchedpub", name="searchedpub")
 */
public function search(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
{
   
    $soponsorRepository = $em->getRepository(Publicite::class);
  // deserialize the form data into an array
 

  // retrieve the search query from the 'query' attribute
    $queryBuilder = $soponsorRepository->createQueryBuilder('b');
    
    $search = $request->query->get('search');
   

    
    
        $queryBuilder->where('b.nomPub LIKE :search OR b.description LIKE :search OR b.image LIKE :search ')
                     ->setParameter('search', "%$search%");

    
    $result = $queryBuilder->getQuery()->getResult();
    $json=$serializer->serialize($result,'json',['groups'=>'Publicite']);
   
    
    return new Response($json);
}









    /**
     * @Route("/afficherP", name="affi")
     */
    public function affidd(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $pub = $em->getRepository(Publicite::class)->findAll();
        
        $json=$serializerInterface->serialize($pub,'json',['groups'=>'Publicite']);
      
        return new Response($json);
    }








    /**
     * @Route("/afficherPublicitejSON", name="afficherPublicitee")
     */
    public function afficherPub(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $pub = $em->getRepository(Publicite::class)->findAll();
        
        $json=$serializerInterface->serialize($pub,'json',['groups'=>'Publicite']);
        return new Response($json);
    }


    /**
     * @Route("/registerPublicite", name="registerPublicite")
     */
    public function registerPublicite( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Pub = new Publicite();


        $Pub->setNomPub($request->query->get("Nom"));
        $Pub->setDescription($request->query->get("Description"));
        $Pub->setImage($request->query->get("Image"));

        $Sponsor=$manager->getRepository(Sponsor::class)->findOneBy(array('id'=>$request->query->get("id_sponsor")));
        $Pub->setIdSponsor($Sponsor);
        $manager->persist($Pub);
        $manager->flush();
        $json=$serializer->serialize($Pub,'json',['groups'=>'Publicite']);
        return new Response($json);
    }


    /**
     * @Route("/updatePublicite", name="updatePublicite")
     */
    public function updatePublicite( Request $request,serializerInterface $serializer,EntityManagerInterface $entityManager)
        {
            $Pub = new Publicite();
            $Pub=$entityManager->getRepository(Publicite::class)->findOneBy(array('id'=>$request->query->get("id")));
            $Pub->setNomPub($request->query->get("Nom"));
            $Pub->setDescription($request->query->get("Description"));
            $Pub->setImage($request->query->get("Image"));
            $entityManager->persist($Pub);
            $entityManager->flush();

            return new Response("success");

        }

    
        
    /**
* @Route("/deletePublicitejson", name="deletePublicitejson")
*/
public function deletePubliciteee( 
    Request $request,
    serializerInterface $serializer,
    EntityManagerInterface $entityManager
){

$Pub=$entityManager->getRepository(Publicite::class)->findOneBy(array('id'=>$request->query->get("id")));

$entityManager->remove($Pub);
$entityManager->flush();
return new Response("success");

}










}

