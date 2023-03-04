<?php

namespace App\Controller;
use App\Entity\Publicite;
use App\Entity\Rating;
use App\Entity\Utilisateur;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface ;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PubliciteType;
use App\Form\UpdatepubliciteType;
use Symfony\Component\Serializer\SerializerInterface;

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
       $user=$entityManagerInterface->getRepository(Utilisateur::class)->findOneBy(array('id'=>"1"));
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
    public function addpublicite(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
       $publicite=new publicite();
       $form=$this->createForm(PubliciteType::class,$publicite);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){


        /** @var UploadedFile $file */
        $file = $form->get('image')->getData();
        $filename=md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
         $this->getParameter('Images_directory'),
         $filename
         
     );

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
     * @Route("/stats", name="stats")
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










}

