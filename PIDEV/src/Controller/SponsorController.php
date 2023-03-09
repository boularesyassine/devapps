<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SearchFormType;
use App\Form\SponsorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SponsorController extends AbstractController
{
    #[Route('/sponsor', name: 'app_sponsor')]
    public function index(): Response
    {
        return $this->render('sponsor/index.html.twig', [
            'controller_name' => 'SponsorController',
        ]);
    }




    /**
     * @Route("/displaysponsor", name="displaysponsor")
     */
    public function afficherSponsors(EntityManagerInterface $em): Response
    {
        $Sponsors= $em->getRepository(Sponsor::class)->findAll();
        $form=$this->createForm(SearchFormType::class);
        return $this->render('sponsor/index.html.twig', [
            'b'=>$Sponsors,
            'f'=>$form->createView()
        ]);
    }






    /**
     * @Route("/frontsponsor", name="frontsponsor")
     */
    public function frontsponsor(EntityManagerInterface $em): Response
    {
        $Sponsors= $em->getRepository(Sponsor::class)->findAll();
 
        return $this->render('sponsor/frontsponsor.html.twig', [
            'b'=>$Sponsors
        ]);
    }





    /**
     * @Route("/addSponsor", name="addSponsor")
     */
    public function addSponsor(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
       $Sponsor=new Sponsor();
       $form=$this->createForm(SponsorType::class,$Sponsor);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $entityManagerInterface->persist($Sponsor);
           $entityManagerInterface->flush();

           return $this->redirectToRoute('displaysponsor');
       }
       else
       return $this->render('sponsor/ajouterSponsor.html.twig',['f'=>$form->createView()]);

    }


    /**
     * @Route("/modifierSponsor/{id}", name="modifierSponsor")
     */
    public function modifierEvent(Request $request,EntityManagerInterface $em,$id): Response
    {
      
       $Sponsor=$em->getRepository(Sponsor::class)->find($id);
       $form=$this->createForm(SponsorType::class,$Sponsor);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){           
           $em->flush();

           return $this->redirectToRoute('displaysponsor');
       }
       else
       return $this->render('sponsor/modifierSponsor.html.twig',['f'=>$form->createView()]);

    }


    /**
* @Route("/deleteSponsor", name="deleteSponsor")
*/
public function deleteSponsor(Request $request, EntityManagerInterface $entityManager)
{

    $Sponsor=$entityManager->getRepository(Sponsor::class)->findOneBy(array('id'=>$request->query->get("id")));
    $entityManager->remove($Sponsor);
    $entityManager->flush();
    //return new Response("success");

    $Sponsor= $entityManager->getRepository(Sponsor::class)->findAll();
        return $this->render('sponsor/index.html.twig', [
            'b'=>$Sponsor
        ]);
}

















    /**
     * @Route("/afficherSponsorjSON", name="afficherSponsore")
     */
    public function afficherPub(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $pub = $em->getRepository(Sponsor::class)->findAll();
        
        $json=$serializerInterface->serialize($pub,'json',['groups'=>'Sponsor']);
        return new Response($json);
    }


    /**
     * @Route("/registerSponsor", name="registerSponsor")
     */
    public function registerSponsor( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Pub = new Sponsor();


        $Pub->setNom($request->query->get("nom"));
        $Pub->setAdresse($request->query->get("adresse"));
        $Pub->setEmail($request->query->get("email"));

        $Pub->setNumTel((int) $request->query->get("num_tel"));
        $manager->persist($Pub);
        $manager->flush();
        $json=$serializer->serialize($Pub,'json',['groups'=>'Sponsor']);
        return new Response($json);
    }


    /**
     * @Route("/updateSponsor", name="updateSponsor")
     */
    public function updateSponsor( Request $request,serializerInterface $serializer,EntityManagerInterface $entityManager)
        {
            $Pub = new Sponsor();
            $Pub=$entityManager->getRepository(Sponsor::class)->findOneBy(array('id'=>$request->query->get("id")));
            $Pub->setNom($request->query->get("nom"));
            $Pub->setAdresse($request->query->get("adresse"));
            $Pub->setEmail($request->query->get("email"));
            $Pub->setNumTel($request->query->get("num_tel"));
            $entityManager->persist($Pub);
            $entityManager->flush();

            return new Response("success");

        }

    
        
    /**
    * @Route("/deleteSponsorjson", name="deleteSponsorjson")
    */
    public function deleteSponsoree( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager
    ){

    $Pub=$entityManager->getRepository(Sponsor::class)->findOneBy(array('id'=>$request->query->get("id")));

    $entityManager->remove($Pub);
    $entityManager->flush();
    return new Response("success");

    }





}



