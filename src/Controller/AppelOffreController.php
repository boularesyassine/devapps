<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Form\AppelOffreType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class AppelOffreController extends AbstractController
{
    #[Route('/', name: 'app_appel_offre')]
    public function index(): Response
    {
        return $this->render('basefront.html.twig', [
            'controller_name' => 'AppelOffreController',
        ]);
    }


    /**
     * @Route("/afficheroffre", name="afficheroffre")
     */
    public function afficherAppelOffre(EntityManagerInterface $em): Response
    {
        $offre= $em->getRepository(AppelOffre::class)->findAll();
        return $this->render('appel_offre/index.html.twig', [
            'offres'=>$offre
        ]);
    }







    /**
     * @Route("/addOffre", name="addOffre")
     */
    public function addOffre(Request $request,EntityManagerInterface $EM): Response
    {
      
       $Offre=new AppelOffre();
       $form=$this->createForm(AppelOffreType::class,$Offre);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Offre->setDate(new DateTime());

           $EM->persist($Offre);
           $EM->flush();

           return $this->redirectToRoute('afficheroffre');
       }
       else
       return $this->render('appel_offre/ajouterOffre.html.twig',['f'=>$form->createView()]);

    }

   /**
     * @Route("/addOffrefront", name="addOffrefront")
     */
    public function addOffrefront(Request $request,EntityManagerInterface $EM): Response
    {
      
       $Offre=new AppelOffre();
       $form=$this->createForm(AppelOffreType::class,$Offre);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $Offre->setDate(new DateTime());

           $EM->persist($Offre);
           $EM->flush();

           return $this->redirectToRoute('afficheroffre');
       }
       else
       return $this->render('appel_offre/ajouterOffre.html.twig',['f'=>$form->createView()]);

    }



    
    /**
     * @Route("/modifierOffre/{id}", name="modifierOffre")
     */
    public function modifierOffre(Request $request,$id,EntityManagerInterface $EM): Response
    {
      
       $Offre=$EM->getRepository(AppelOffre::class)->find($id);
       $form=$this->createForm(AppelOffreType::class,$Offre);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           
           $EM->flush();

           return $this->redirectToRoute('afficheroffre');
       }
       else
       return $this->render('appel_offre/modifierOffre.html.twig',['f'=>$form->createView()]);

    }



    /**
* @Route("/deleteOffre", name="deleteOffre")
*/
    public function deleteOffre(Request $request,EntityManagerInterface $EM)
    {

        $Offre=$EM->getRepository(AppelOffre::class)->findOneBy(array('id'=>$request->query->get("id")));
        $EM->remove($Offre);
        $EM->flush();
        return $this->render('appel_offre/index.html.twig', [
            'offres'=>$Offre
        ]);

    }

}