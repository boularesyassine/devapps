<?php

namespace App\Controller;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieType;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categories", name="displaycategorie")
     */
    public function afficherCategories(): Response
    {
        $categories= $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'b'=>$categories
        ]);
    }

    /**
     * @Route("/addcategorie", name="addcategorie")
     */
    public function addcategorie(Request $request): Response
    {
      
       $categorie=new categorie();
       $form=$this->createForm(categorieType::class,$categorie);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $em->persist($categorie);
           $em->flush();

           return $this->redirectToRoute('displaycategorie');
       }
       else
       return $this->render('categorie/ajoutercategorie.html.twig',['f'=>$form->createView()]);

    }

      /**
     * @Route("/displayfrontcategorie", name="displayfrontcategorie")
     */
    public function displayfrontcategorie(): Response
    {
        $categories= $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/indexfront.html.twig', [
            'b'=>$categories
        ]);
    }

    
    /**
     * @Route("/modifiercategorie/{id}", name="modifiercategorie")
     */
    public function modifiercategorie(Request $request,$id): Response
    {
      
       $categorie=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($id);
       $form=$this->createForm(CategorieType::class,$categorie);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displaycategorie');
       }
       else
       return $this->render('categorie/modifiercategorie.html.twig',['f'=>$form->createView()]);

    }

      /**
* @Route("/deletecategorie", name="deletecategorie")
*/
public function deletecategorie( 
    Request $request,
    
){

$categorie=$this->getDoctrine()->getRepository(Categorie::class)->findOneBy(array('id'=>$request->query->get("id")));
$em=$this->getDoctrine()->getManager();
$em->remove($categorie);
$em->flush();
$categories= $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
return $this->render('categorie/index.html.twig', [
    'b'=>$categories
]);
}

}
