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
 * @Route("/search", name="search")
 */
public function search(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
{
   
    $soponsorRepository = $em->getRepository(Sponsor::class);
  // deserialize the form data into an array
  $search = $request->query->get('search_form');

  $query= $search["searchQuery"];
  $sort = $search["orderby"];

  // retrieve the search query from the 'query' attribute
    $queryBuilder = $soponsorRepository->createQueryBuilder('b');
    
    $search = $request->query->get('searchQuery');
   

    
    
        $queryBuilder->where('b.nom LIKE :search OR b.adresse LIKE :search OR b.email LIKE :search ')
                     ->setParameter('search', "%$query%");
    
    
    if ($sort ) {
        $queryBuilder->orderBy("b.$sort","ASC");
    }
    
    $result = $queryBuilder->getQuery()->getResult();
    $json=$serializer->serialize($result,'json',['groups'=>'Sponsor']);
   
    
    return $this->json([
        'results' => $this->renderView('sponsor/result.html.twig', [
            'b' => $result,
           
            
        ]),
    
       
    ]);
}





}



