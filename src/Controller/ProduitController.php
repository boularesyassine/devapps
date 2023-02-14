<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProduitTType;
class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    /**
     * @Route("/p", name="displayproduit")
     */
    public function afficherProduits(): Response
    {
        $produits= $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('produit/index.html.twig', [
            'b'=>$produits
        ]);
    }

   /**
     * @Route("/addproduit", name="addproduit")
     */
    public function addproduit(Request $request): Response
    {
      
       $produit=new produit();
       $form=$this->createForm(ProduitTType::class,$produit);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $em->persist($produit);
           $em->flush();

           return $this->redirectToRoute('displayproduit');
       }
       else
       return $this->render('produit/ajouterproduit.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/modifierproduit/{id_produit}", name="modifierproduit")
     */
    public function modifierproduit(Request $request,$id_produit): Response
    {
      
       $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id_produit);
       $form=$this->createForm(ProduitTType::class,$produit);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayproduit');
       }
       else
       return $this->render('produit/modifierproduit.html.twig',['f'=>$form->createView()]);

    }



    /**
* @Route("/deleteProduit", name="deleteProduit")
*/
public function deleteProduit( 
    Request $request,
    
){

$Produit=$this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit'=>$request->query->get("id_produit")));
$em=$this->getDoctrine()->getManager();
$em->remove($Produit);
$em->flush();
return new Response("success");

}

}
