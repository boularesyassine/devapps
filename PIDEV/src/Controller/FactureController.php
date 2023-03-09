<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FactureType;
use App\Form\UpdateFactureType;
use App\Entity\Facture;
use App\Entity\Utilisateur;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Flex\Options;
use DateTime;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="app_facture")
     */
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }



       






    /**
     * @Route("/displayFacture", name="displayFacture")
     */
    public function afficherFactures(): Response
    {
        $Factures= $this->getDoctrine()->getManager()->getRepository(Facture::class)->findAll();
        return $this->render('facture/index.html.twig', [
            'b'=>$Factures
        ]);
    }
     /**
     * @Route("/addfactures", name="addfactures")
     */
    public function addFacture(Request $request,\Swift_Mailer $mailer): Response
    {
      
       $Facture=new Facture();
       $form=$this->createForm(FactureType::class,$Facture);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        /** @var UploadedFile $file */
        $file = $form->get('image')->getData();
        $filename=md5(uniqid()).'.'.$file->guessExtension();
        $file->move(
         $this->getParameter('Images_directory'),
         $filename
         
     );
     
     $message = (new \Swift_Message(' hi new facture has been added please check your reclmations'))
     ->setFrom('yassine.boulares@esprit.tn')
     ->setTo('yassine.boulares@esprit.tn')
     ->setBody(" hi new facture has been added please check your reclmations")

 ;

 $mailer->send($message);
     $Facture->setImage($filename);
           $em = $this->getDoctrine()->getManager();
           $em->persist($Facture);
           $em->flush();

           return $this->redirectToRoute('displayFacture');
       }
       else
       return $this->render('facture/ajouterFacture.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/modifierFacture/{id}", name="modifierFacture")
     */
    public function modifierFacture(Request $request,$id): Response
    {
      
       $Facture=$this->getDoctrine()->getManager()->getRepository(Facture::class)->find($id);
       $form=$this->createForm(UpdateFactureType::class,$Facture);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayFacture');
       }
       else
       return $this->render('facture/modifierFacture.html.twig',['f'=>$form->createView()]);

    }



/**
* @Route("/deleteFacture", name="deleteFacture")
*/
public function deleteFacture( 
    Request $request
    
){

$Facture=$this->getDoctrine()->getRepository(Facture::class)->findOneBy(array('idFacture'=>$request->query->get("id")));
$em=$this->getDoctrine()->getManager();
$em->remove($Facture);
$em->flush();
//return new Response("success");

$Facture= $this->getDoctrine()->getManager()->getRepository(Facture::class)->findAll();
        return $this->render('facture/index.html.twig', [
            'b'=>$Facture
        ]);}




















    /**
     * @Route("/afficherfacturejSONe", name="afficheroffreeeee")
     */
    public function afficherAppelOffree(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $Facture = $em->getRepository(Facture::class)->findAll();
        $json=$serializerInterface->serialize($Facture,'json',['groups'=>'facture']);
   
        return new Response($json);
    }



/**
     * @Route("/registerFacture", name="registerFactureee")
     */
    public function registerFacture( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Facture = new Facture();


        
        $Facture->setNumero((int)$request->query->get("numero"));
        $Facture->setNom((string)$request->query->get("nom"));
        $Facture->setPrix((float)$request->query->get("prix"));
        $Facture->setDate(new  DateTime());
        $Facture->setEtat((string)$request->query->get("etat"));
        $Facture->setDescription((string)$request->query->get("description"));
        $Facture->setImage((string)$request->query->get("image"));
        $id=$manager->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id_Utilisteur")));

    
        $Facture->setIdUtilisateur($id);
        $manager->persist($Facture);
        $manager->flush();
        $json=$serializer->serialize($Facture,'json',['groups'=>'facture']);
        return new Response($json);
    }

/**
     * @Route("/updateFacture", name="updateFacture")
     */
    public function updateFacture( Request $request,serializerInterface $serializer,EntityManagerInterface $entityManager)
        {
            $Facture = new Facture();
            $Facture=$entityManager->getRepository(Facture::class)->findOneBy(array('idFacture'=>$request->query->get("id_facture")));
         
            $Facture->setNom($request->query->get("nom"));
        
            $Facture->setPrix((int)$request->query->get("prix"));
            $Facture->setEtat((float)$request->query->get("etat"));
            $Facture->setDescription($request->query->get("description"));
            $entityManager->persist($Facture);
            $entityManager->flush();

            return new Response("success");
        }

        /**
        * @Route("/deletefacturejson", name="deletefacturejson")
        */
        public function deleteFacturee( 
                Request $request,
                serializerInterface $serializer,
                EntityManagerInterface $entityManager
        ){
        
            $Facture=$entityManager->getRepository(Facture::class)->findOneBy(array('idFacture'=>$request->query->get("id_facture")));
        
            $entityManager->remove($Facture);
            $entityManager->flush();
            return new Response("success");
           
        }


        /**
     * @Route("/searched", name="search")
     */
    public function searched(Request $request, serializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $bacRepository = $em->getRepository(Facture::class);
        // deserialize the form data into an array
       
        // retrieve the search query from the 'query' attribute
        $queryBuilder = $bacRepository->createQueryBuilder('b');

        $search = $request->query->get('search');




        $queryBuilder->where('b.nom LIKE :search OR b.etat LIKE :search OR b.description LIKE :search OR b.idFacture  LIKE :search')
            ->setParameter('search', "%$search%");


       

        $result = $queryBuilder->getQuery()->getResult();
        $json = $serializer->serialize($result, 'json', ['groups' => 'facture']);

        return new Response($json);
       
    }



}
