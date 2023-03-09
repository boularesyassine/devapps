<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Demande;
use App\Entity\Favorie;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProduitTType;
use App\Form\SearchFormproduitType;
use App\Form\UpdateProduitType;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

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
        $produits = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $form = $this->createForm(SearchFormproduitType::class);

        return $this->render('produit/index.html.twig', [
            'b' => $produits,
            'f' => $form->createView()
        ]);
    }


    /**
     * @Route("/affiherfavorieutlisateur", name="affiherfavorieutlisateur")
     */
    public function affiherfavorieutlisateur(Request $request): Response
    {
        $favorie = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $utlisateur = new Utilisateur();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $dd = $this->getDoctrine()->getRepository(Favorie::class)->findAll(array('id' => $utlisateur->getId()));


        foreach ($dd as $valeur) {
            $product = $this->getDoctrine()->getRepository(Produit::class)->findAll(array('id' => $valeur->getIdproduit()->getid()));
        }

        return $this->render('produit/listfavoriefront.html.twig', [
            'b' => $product
        ]);
    }



    /**
     * @Route("/displaydemande", name="displaydemande")
     */
    public function displaydemande(): Response
    {
        $demande = $this->getDoctrine()->getManager()->getRepository(Demande::class)->findAll();


        return $this->render('produit/demande.html.twig', [
            'b' => $demande
        ]);
    }


    /**
     * @Route("/diplayfavorie", name="diplayfavorie")
     */
    public function diplayfavorie(): Response
    {
        $favorie = $this->getDoctrine()->getManager()->getRepository(Favorie::class)->findAll();


        return $this->render('produit/favorie.html.twig', [
            'b' => $favorie
        ]);
    }
    /**
     * @Route("/displayfront", name="displayfront")
     */
    public function displayfront(Request $request,PaginatorInterface $Paginator): Response
    {
        $id = $request->query->get('id');

    
            $produits = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy(['idCategorie' => $id]);
            $pagination = $Paginator->paginate(
                $produits, // données à paginer
                $request->query->getInt('page', 1), // numéro de la page par défaut
                2 // nombre d'éléments par page
            );
            return $this->render('produit/indexfront.html.twig', [
                'b' => $pagination
            ]);
    }



    /**
     * @Route("/addproduit", name="addproduit")
     */
    public function addproduit(Request $request): Response
    {

        $produit = new produit();
        $form = $this->createForm(ProduitTType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setDate(new DateTime());
            /** @var UploadedFile $file */
            $file = $form->get('photo')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('Images_directory'),
                $filename
            );
            $produit->setPhoto($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('displayproduit');
        } else
            return $this->render('produit/ajouterproduit.html.twig', ['f' => $form->createView()]);
    }

    /**
     * @Route("/modifierproduit/{id_produit}", name="modifierproduit")
     */
    public function modifierproduit(Request $request, $id_produit): Response
    {

        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id_produit);
        $form = $this->createForm(UpdateProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('displayproduit');
        } else
            return $this->render('produit/modifierproduit.html.twig', ['f' => $form->createView()]);
    }



    /**
     * @Route("/deleteProduit", name="deleteProduit")
     */
    public function deleteProduit(
        Request $request,

    ) {

        $Produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit' => $request->query->get("id_produit")));
        $em = $this->getDoctrine()->getManager();
        $em->remove($Produit);
        $em->flush();
        $produits = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('produit/index.html.twig', [
            'b' => $produits
        ]);
    }


    /**
     * @Route("/searchproduit", name="searchproduit")
     */
    public function search(Request $request, SerializerSerializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $bacRepository = $em->getRepository(Produit::class);
        // deserialize the form data into an array
        $search = $request->query->get('search_formproduit');
        $query = $search["searchQuery"];
        $sort = $search["orderby"];
        // retrieve the search query from the 'query' attribute
        $queryBuilder = $bacRepository->createQueryBuilder('b');

        $search = $request->query->get('searchQuery');




        $queryBuilder->where('b.nomProduit LIKE :search OR b.description LIKE :search OR b.prix LIKE :search OR b.quantite LIKE :search')
            ->setParameter('search', "%$query%");


        if ($sort) {
            $queryBuilder->orderBy("b.$sort","ASC");
        }

        $result = $queryBuilder->getQuery()->getResult();
        $json = $serializer->serialize($result, 'json', ['groups' => 'produit']);


        return $this->json([
            'results' => $this->renderView('produit/result.html.twig', [
                'b' => $result,


            ]),


        ]);
    }

    /**
     * @Route("/ajouterdemande", name="ajouterdemande")
     */
    public function ajouterdemande(Request $request): Response
    {

        $Demande = new Demande();
        $Produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit' => $request->query->get("id")));
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $Demande->setDate(new DateTime());

        $Demande->setIdproduit($Produit);
        $Demande->setIdutilisateur($user);



        $em = $this->getDoctrine()->getManager();
        $em->persist($Demande);
        $em->flush();


        return $this->redirectToRoute('displaydemande');
    }



    /**
     * @Route("/ajouterfavorie", name="ajouterfavorie")
     */
    public function ajouterfavorie(Request $request): Response
    {

        $favorie = new Favorie();
        $Produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit' => $request->query->get("id")));
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $favorie->setDate(new DateTime());

        $favorie->setIdproduit($Produit);
        $favorie->setIdutilisateur($user);



        $em = $this->getDoctrine()->getManager();
        $em->persist($favorie);
        $em->flush();


        return $this->redirectToRoute('affiherfavorieutlisateur');
    }












/**
     * @Route("/searchedjson", name="searchedjson")
     */
    public function searched(Request $request, SerializerSerializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $bacRepository = $em->getRepository(Produit::class);
        // deserialize the form data into an array
       
        // retrieve the search query from the 'query' attribute
        $queryBuilder = $bacRepository->createQueryBuilder('b');

        $search = $request->query->get('search');




        $queryBuilder->where('b.nomProduit LIKE :search OR b.description LIKE :search OR b.prix LIKE :search OR b.quantite LIKE :search')
            ->setParameter('search', "%$search%");


       

        $result = $queryBuilder->getQuery()->getResult();
        $json = $serializer->serialize($result, 'json', ['groups' => 'Produit']);

        return new Response($json);
       
    }



















    /**
     * @Route("/Produitlistjson",name="Produitlistjson")
     */

    public function getProduits(SerializerSerializerInterface $serializer)
    {
        $Produits = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $json = $serializer->serialize($Produits, 'json', ['groups' => 'Produit']);
        return new Response($json);
    }
    /**
     * @Route("/addProduitjson", name="addProduitjson")
     */
    public function registerProduit(Request $request, SerializerSerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $Produit = new Produit();


        $nom = $request->query->get("nomProduit");

        $description = $request->query->get("description");
        $Prix1 = $request->query->get("prix");

        $quantite = $request->query->get("quantite");


        $Photo = $request->query->get("photo");
        $date = new DateTime();
        $categorie = $request->query->get("idCategorie");


        $dateString = $date->format('Y-m-d H:i:s');
        $sql = "INSERT INTO `produit`( `nom_produit`, `description`, `prix`, `quantite`, `photo`, `date`, `id_categorie_id`) VALUES 
    ('$nom',' $description','$Prix1','$quantite','$Photo','$dateString','$categorie')";
        $stmt = $manager->getConnection()->prepare($sql);
        $result = $stmt->execute();

        return new Response("sucess");
    }



    /**
     * @Route("/updateProduit", name="updateProduit")
     */
    public function updateProduit(
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $Produit = new Produit();
        $Produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit' => $request->query->get("id")));

        $Produit->setNomProduit($request->query->get("nomProduit"));
        $Produit->setDescription($request->query->get("description"));
    

        $Produit->setPrix($request->query->get("prix"));
        $quantite =$request->query->get("quantite");
        $Produit->setQuantite($quantite);
        $entityManager->persist($Produit);
        $entityManager->flush();

        return new Response("success");
    }

    /**
     * @Route("/deleteProduitt", name="deleteprod")
     */
    public function deleteProduitt(Request $request, serializerInterface $serializer, EntityManagerInterface $entityManager)
    {

        $Produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('idProduit' => $request->query->get("id")));
        $em = $this->getDoctrine()->getManager();
        $em->remove($Produit);
        $em->flush();
        return new Response("success");
    }
}
