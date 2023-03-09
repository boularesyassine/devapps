<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FinanceType;
use App\Form\FinancenewType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Facture;
use App\Entity\Finance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

class FinanceController extends AbstractController
{
    /**
     * @Route("/finance", name="app_finance")
     */
    public function index(): Response
    {
        return $this->render('finance/index.html.twig', [
            'controller_name' => 'FinanceController',
        ]);
    }



    /**
     * @Route("/displayFinance", name="displayFinance")
     */
    public function afficherFinances(): Response
    {
        $Finances= $this->getDoctrine()->getManager()->getRepository(Finance::class)->findAll();
        return $this->render('finance/index.html.twig', [
            'b'=>$Finances
        ]);
    }
     /**
     * @Route("/addFinances", name="addFinances")
     */
    public function addFinance(Request $request): Response
    {
      
       $Finance=new Finance();
       $form=$this->createForm(FinanceType::class,$Finance);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $em->persist($Finance);
           $em->flush();

           return $this->redirectToRoute('displayFinance');
       }
       else
       return $this->render('finance/ajouterFinance.html.twig',['f'=>$form->createView()]);

    }
/**
     * @Route("/addFinancefromfacture/{id}", name="addFinancefromfacture")
     */
    public function addFinancefromfacture(Request $request,$id): Response
    {
      
        $Finance=new Finance();
        $form=$this->createForm(FinancenewType::class,$Finance);
        $facture=$this->getDoctrine()->getManager()->getRepository(Facture::class)->find($id);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $Finance->setIdFacture($facture);
            $em->persist($Finance);
            $em->flush();
 
            return $this->redirectToRoute('displayFinance');
        }
        else
        return $this->render('finance/ajouterFinanceforfacture.html.twig',['f'=>$form->createView()]);

    }







    /**
     * @Route("/modifierFinance/{id}", name="modifierFinance")
     */
    public function modifierFinance(Request $request,$id): Response
    {
      
       $Finance=$this->getDoctrine()->getManager()->getRepository(Finance::class)->find($id);
       $form=$this->createForm(FinanceType::class,$Finance);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayFinance');
       }
       else
       return $this->render('finance/modifierFinance.html.twig',['f'=>$form->createView()]);

    }



    /**
* @Route("/deleteFinance", name="deleteFinance")
*/
public function deleteFinance( 
    Request $request
    
){

$Finance=$this->getDoctrine()->getRepository(Finance::class)->findOneBy(array('id'=>$request->query->get("id")));
$em=$this->getDoctrine()->getManager();
$em->remove($Finance);
$em->flush();
//return new Response("success");
$Finance= $this->getDoctrine()->getManager()->getRepository(Finance::class)->findAll();
        return $this->render('finance/index.html.twig', [
            'b'=>$Finance
        ]);

}


























    /**
     * @Route("/afficherfinancejSON", name="afficheroffree")
     */
    public function afficherAppelOffree(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $finance = $em->getRepository(Finance::class)->findAll();

        $json=$serializerInterface->serialize($finance,'json',['groups'=>'finance']);
      
        return new Response($json);
    }


/**
     * @Route("/registerFinance", name="registerFinanceee")
     */
    public function registerFinance( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Finance = new Finance();


        
        $Finance->setTaxe((int)$request->query->get("taxe"));
        $Finance->setTva((float)$request->query->get("tva"));
        $Finance->setPhoto($request->query->get("photo"));
        $Finance->setPrix($request->query->get("prix"));
        $Finance->setEtat($request->query->get("etat"));
        $Finance->setDate(new DateTime());
        $facture=$manager->getRepository(Facture::class)->findOneBy(array('idFacture'=>$request->query->get("id_facture")));

    
        $Finance->setIdFacture($facture);
        $manager->persist($Finance);
        $manager->flush();
        $json=$serializer->serialize($Finance,'json',['groups'=>'Finance']);
        return new Response($json);
    }

/**
     * @Route("/updateFinance", name="updateFinance")
     */
    public function updateFinance( Request $request,serializerInterface $serializer,EntityManagerInterface $entityManager)
        {
            $Finance = new Finance();
            $Finance=$entityManager->getRepository(Finance::class)->findOneBy(array('id'=>$request->query->get("id")));
         
            $Finance->setTva($request->query->get("tva"));
        
            $Finance->setTaxe((int)$request->query->get("taxe"));
            $Finance->setPrix((float)$request->query->get("prix"));
            $Finance->setEtat($request->query->get("etat"));
            $entityManager->persist($Finance);
            $entityManager->flush();

            return new Response("success");
        }

        /**
        * @Route("/deletefinancejson", name="deletefinancejson")
        */
        public function deleteFinancee( 
                Request $request,
                serializerInterface $serializer,
                EntityManagerInterface $entityManager
        ){
        
            $Finance=$entityManager->getRepository(Finance::class)->findOneBy(array('id'=>$request->query->get("id")));
        
            $entityManager->remove($Finance);
            $entityManager->flush();
            return new Response("success");
           
        }

}
