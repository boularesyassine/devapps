<?php

namespace App\Controller;
use App\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface ;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PubliciteType;
use App\Form\UpdatepubliciteType;

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




}

