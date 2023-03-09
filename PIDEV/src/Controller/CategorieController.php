<?php

namespace App\Controller;
use App\Entity\Publicite;
use PDO;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;


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
        $categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'b' => $categories
        ]);
    }

    /**
     * @Route("/addcategorie", name="addcategorie")
     */
    public function addcategorie(Request $request): Response
    {

        $categorie = new categorie();
        $form = $this->createForm(categorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('displaycategorie');
        } else
            return $this->render('categorie/ajoutercategorie.html.twig', ['f' => $form->createView()]);
    }

    /**
     * @Route("/displayfrontcategorie", name="displayfrontcategorie")
     */
    public function displayfrontcategorie(EntityManagerInterface $em): Response
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





        $categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/indexfront.html.twig', [
            'b' => $categories, 'pub'=>$publicite
        ]);
    }


    /**
     * @Route("/modifiercategorie/{id}", name="modifiercategorie")
     */
    public function modifiercategorie(Request $request, $id): Response
    {

        $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('displaycategorie');
        } else
            return $this->render('categorie/modifiercategorie.html.twig', ['f' => $form->createView()]);
    }

    /**
     * @Route("/deletecategorie", name="deletecategorie")
     */
    public function deletecategorie(
        Request $request,

    ) {

        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(array('id' => $request->query->get("id")));
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        $categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'b' => $categories
        ]);
    }










    
/**
     * @Route("/statsproduit", name="statsproduit")
     */
    public function statistiques(EntityManagerInterface $em){
        $dates = [];
        $produitCount = [];
        $categColor = [];
       
        $sql = "SELECT nom , id FROM categorie";
        $stmt = $em->getConnection()->prepare($sql);
        $result = $stmt->execute();



        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $dates[] = $row["nom"];
            $produitCount[] = $row["id"];
            $sql2 = "SELECT COUNT(id_produit)  as somme from produit where id_categorie_id=".strval($row["id"]) ;
             $stmt2 = $em->getConnection()->prepare($sql2);
            $result2 = $stmt2->execute();
            $row2 = $result2->fetch(PDO::FETCH_ASSOC);
            if($row2["somme"]==null)
            {
                $categColor[]=0;
            }
            else
            $categColor[] = $row2["somme"];
 
        }
    
        // On va chercher toutes les catégories
   
       
      
  
  
        return $this->render('produit/stat.html.twig', [
            'dates' => json_encode($dates),
            'produitCount' => json_encode($categColor),
        ]);
  
  
    }































    /**
     * @Route("/Categorielistjson",name="Categorielistjson")
     */

    public function getCategories(SerializerInterface $serializer)
    {
        $Categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();

        $json = $serializer->serialize($Categories, 'json', ['groups' => 'Categorie']);
        return new Response($json);
    }
    /**
     * @Route("/addCategoriejson", name="addCategoriejson")
     */
    public function registerCategorie(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $Categorie = new Categorie();




        $Categorie->setNom($request->query->get("nomcategorie"));


        $manager->persist($Categorie);
        $manager->flush();
        $json = $serializer->serialize($Categorie, 'json', ['groups' => 'user']);
        return new Response($json);
    }




    /**
     * @Route("/updateCategorie", name="updateCategorie")
     */
    public function updateCategorie(
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $Categorie = new Categorie();
        $Categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(array('id' => $request->query->get("id")));

        $Categorie->setNom($request->query->get("nomcategorie"));

        $entityManager->persist($Categorie);
        $entityManager->flush();

        return new Response("success");
    }

    /**
     * @Route("/deleteCategoriett", name="deletecateogoriet")
     */
    public function deleteCategoriet(Request $request, serializerInterface $serializer, EntityManagerInterface $entityManager)
    {

        $Categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(array('id' => $request->query->get("id")));
        $em = $this->getDoctrine()->getManager();
        $em->remove($Categorie);
        $em->flush();
        return new Response("success");
    }
}
