<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Entity\Categorie;
use App\Entity\ReponseOffre;
use App\Entity\Utilisateur;
use App\Form\ReponsenewFormType;
use App\Form\ReponseOffreType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;

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
    public function afficherReponseOffre(EntityManagerInterface $em,PaginatorInterface $Paginator,Request $request): Response
    {
        $Reponse= $em->getRepository(ReponseOffre::class)->findAll();
        $pagination = $Paginator->paginate(
            $Reponse, // données à paginer
            $request->query->getInt('page', 1), // numéro de la page par défaut
            2 // nombre d'éléments par page
        );
        return $this->render('reponse_offre/index.html.twig', [
            'reponse'=>$pagination
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
        $offre=$EM->getRepository(AppelOffre::class)->find($Reponse->getIdOffre());
        $Reponse->setNomProduit($offre->getNom());

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
    public function addReponseforoffre(Request $request,EntityManagerInterface $EM,$id,\Swift_Mailer $mailer): Response
    {
        $offre=$EM->getRepository(AppelOffre::class)->find($id);

       $Reponse=new ReponseOffre();
       $form=$this->createForm( ReponsenewFormType::class,$Reponse);
       $form->handleRequest($request);
       $nom=$offre->getNom();
       if($form->isSubmitted() && $form->isValid()){

        $message = (new \Swift_Message('un reponse est ajouter sur votre appel offre'))
        ->setFrom('mejdi.mohamed@esprit.tn')
        ->setTo('mejdi.mohamed@esprit.tn')
        ->setBody("un reponse est ajouter sur votre appel offre")

    ;

      $mailer->send($message);

        $Reponse->setDate(new DateTime());
        $Reponse->setNomProduit($offre->getNom());

        $Reponse->setIdOffre($offre);
           $EM->persist($Reponse);
           $EM->flush();

           return $this->redirectToRoute('afficherReponseOffre');
       }
       else
       return $this->render('reponse_offre/ajouterReponseforoffre.html.twig',['f'=>$form->createView(),'nom'=>$nom]);

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
$Reponse= $EM->getRepository(ReponseOffre::class)->findAll();
        return $this->render('reponse_offre/index.html.twig', [
            'reponse'=>$Reponse
        ]);

}


  /**
     * @Route("/affichercategorielist", name="affichercategorielist")
     */
    public function affichercategorielist(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $reponse = $em->getRepository(Categorie::class)->findAll();
        
        $json=$serializerInterface->serialize($reponse,'json',['groups'=>'categories']);
        return new Response($json);
    }



    /**
     * @Route("/afficheruserlist", name="afficheruserlist")
     */
    public function afficheruserlist(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $reponse = $em->getRepository(Utilisateur::class)->findAll();
        
        $json=$serializerInterface->serialize($reponse,'json',['groups'=>'utlisateur']);
        return new Response($json);
    }













     /**
     * @Route("/afficherreponsejSON", name="afficherreponsejSON")
     */
    public function afficherAppelOffree(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $reponse = $em->getRepository(ReponseOffre::class)->findAll();
        
        $json=$serializerInterface->serialize($reponse,'json',['groups'=>'Reponse']);
        return new Response($json);
    }


// //afficher un seul reponse d'offre

//     /**
//      * @Route("/detailreponse", name="detailreponse")
//      */
//     public function detailReponseOffre(int $id,EntityManagerInterface $em,Request $request, SerializerInterface $serializerInterface): Response
//     {
//         $reponse = $em->getRepository(ReponseOffre::class)->find(array('id'=>$request->query->get("id")));
        
//         $json=$serializerInterface->serialize($reponse,'json',['groups'=>'offres']);
//         return new JsonResponse($json);
//     }


     /**
     * @Route("/registerreponseOffre", name="registerreponseOffre")
     */
    public function registerreponseOffre( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Offre = new ReponseOffre();


        $Offre->setNomProduit($request->query->get("nom_produit"));
        
        $Offre->setBudget((int)$request->query->get("budget"));
        $Offre->setEtat($request->query->get("Etat"));
        $Offre->setDate(new DateTime());
        $appeloffre=$manager->getRepository(AppelOffre::class)->findOneBy(array('id'=>$request->query->get("id_offre")));

        $Offre->setIdOffre($appeloffre);
  
        $manager->persist($Offre);
        $manager->flush();
        $json=$serializer->serialize($Offre,'json',['groups'=>'Offre']);
        return new Response($json);
    }



     /**
     * @Route("/updateReponseJson", name="updateReponse")
     */
    public function updateOffre( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager)
        {
            $ReponseOffre = new ReponseOffre();
            $ReponseOffre=$entityManager->getRepository(ReponseOffre::class)->findOneBy(array('id'=>$request->query->get("id")));


            $ReponseOffre->setNomProduit($request->query->get("nom_produit"));
        
            $ReponseOffre->setBudget((int)$request->query->get("budget"));
            $ReponseOffre->setEtat($request->query->get("Etat"));
            $ReponseOffre->setDate(new DateTime());
    
      
        $entityManager->persist($ReponseOffre);
    $entityManager->flush();

 return new Response("success");

}

/**
* @Route("/deletereponsejson", name="deletereponsejson")
*/
public function deleteOffreee( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager
){

    $Offre=$entityManager->getRepository(ReponseOffre::class)->findOneBy(array('id'=>$request->query->get("id")));

    $entityManager->remove($Offre);
    $entityManager->flush();
    return new Response("success");
   
}
}
