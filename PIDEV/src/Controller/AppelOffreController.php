<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Form\AppelOffreType;
use App\Form\AppelOffreFormType;
use App\Form\SearchFormoffreType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as SerializationSerializerInterface;

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
    public function afficherAppelOffre(EntityManagerInterface $em,PaginatorInterface $Paginator,Request $request): Response
    {
        $offre = $em->getRepository(AppelOffre::class)->findAll();
        $form=$this->createForm(SearchFormoffreType::class);

        $pagination = $Paginator->paginate(
            $offre, // données à paginer
            $request->query->getInt('page', 1), // numéro de la page par défaut
            2 // nombre d'éléments par page
        );
        return $this->render('appel_offre/index.html.twig', [
            'offres' => $pagination,
            'f'=>$form->createView()
        ]);
    }

 


    
    /**
     * @Route("/afficheroffrefront", name="afficheroffrefront")
     */
    public function afficheroffrefront(EntityManagerInterface $em,Request $request): Response
    {
        $offre = $em->getRepository(AppelOffre::class)->findAll();
      

   
        return $this->render('appel_offre/appeloffrefront.html.twig', [
            'b' => $offre
           
        ]);
    }

  


     
    /**
     * @Route("/addOffre", name="addOffre")
     */
    public function addOffre(Request $request, EntityManagerInterface $EM): Response
    {
        
        $Offre = new AppelOffre();
        $form = $this->createForm(AppelOffreFormType::class, $Offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Offre->setDate(new DateTime());

            $EM->persist($Offre);
            $EM->flush();

            return $this->redirectToRoute('afficheroffre');
        } else
            return $this->render('appel_offre/ajouterOffre.html.twig', ['f' => $form->createView()]);
    }

    /**
     * @Route("/addOffrefront", name="addOffrefront")
     */
    public function addOffrefront(Request $request, EntityManagerInterface $EM): Response
    {

        $Offre = new AppelOffre();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $f=$request->query->get("idcat");
;
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(array('id' => $request->query->get("idcat")));
        $Offre->setIdUtilisateur($user);
        $Offre->setIdCategorie($categorie);
        $form = $this->createForm(AppelOffreType::class, $Offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Offre->setDate(new DateTime());

            $EM->persist($Offre);
            $EM->flush();

            return $this->redirectToRoute('home');
        } else
            return $this->render('appel_offre/ajouterfront.html.twig', ['f' => $form->createView()]);
    }




    /**
     * @Route("/modifierOffre/{id}", name="modifierOffre")
     */
    public function modifierOffre(Request $request, $id, EntityManagerInterface $EM): Response
    {

        $Offre = $EM->getRepository(AppelOffre::class)->find($id);
        $form = $this->createForm(AppelOffreType::class, $Offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {



            $EM->flush();

            return $this->redirectToRoute('afficheroffre');
        } else
            return $this->render('appel_offre/modifierOffre.html.twig', ['f' => $form->createView()]);
    }


  /**
     * @Route("/confirmdelete/{id}", name="confirmdelete")
     */
    public function confirmdelete(Request $request, $id, EntityManagerInterface $EM): Response
    {

        return $this->render('appel_offre/confirmation_delete.html.twig', [
            'id' => $id
        ]);
    }




    /**
     * @Route("/deleteOffre", name="deleteOffre")
     */
    public function deleteOffre(Request $request, EntityManagerInterface $EM)
    {

        $Offre = $EM->getRepository(AppelOffre::class)->findOneBy(array('id' => $request->query->get("id")));
        $EM->remove($Offre);
        $EM->flush();

         $offres = $EM->getRepository(AppelOffre::class)->findAll();
        return $this->render('appel_offre/index.html.twig', [
            'offres' => $offres
        ]);
    }


    

/**
 * @Route("/searchoffre", name="searchoffre")
 */
public function search(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
{
    
    $bacRepository = $em->getRepository(AppelOffre::class);
  // deserialize the form data into an array

  $search = $request->query->get('search_formoffre');
  $query= $search["searchQuery"];
  $sort = $search["orderby"];

  // retrieve the search query from the 'query' attribute
    $queryBuilder = $bacRepository->createQueryBuilder('b');
    
    $search = $request->query->get('searchQuery');
   

    
    
        $queryBuilder->where('b.nom LIKE :search OR b.quantite LIKE :search OR b.budget LIKE :search OR b.budget LIKE :search  OR b.date LIKE :search')
                     ->setParameter('search', "%$query%");
    
    
    if ($sort ) {
        $queryBuilder->orderBy("b.$sort","ASC");
    }
    
    $result = $queryBuilder->getQuery()->getResult();
    $json=$serializer->serialize($result,'json',['groups'=>'offres']);
  
    
    return $this->json([
        'results' => $this->renderView('appel_offre/result.html.twig', [
            'offres' => $result,
           
            
        ]),
    
       
    ]);
}










/**
     * @Route("/searcheded", name="searcheded")
     */
    public function searched(Request $request,EntityManagerInterface $em, SerializerInterface $serializerInterface)
    {
        
        $bacRepository = $em->getRepository(AppelOffre::class);
        // deserialize the form data into an array
       
        // retrieve the search query from the 'query' attribute
        $queryBuilder = $bacRepository->createQueryBuilder('b');

        $search = $request->query->get('search');




        $queryBuilder->where('b.nom LIKE :search OR b.quantite LIKE :search OR b.budget LIKE :search OR b.budget LIKE :search  OR b.date LIKE :search')
            ->setParameter('search', "%$search%");


       

        $result = $queryBuilder->getQuery()->getResult();
        $json = $serializerInterface->serialize($result, 'json', ['groups' => 'offres']);

        return new Response($json);
       
    }























   /**
     * @Route("/afficheroffreejSON", name="afficheroffree")
     */
    public function afficherAppelOffree(EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $offre = $em->getRepository(AppelOffre::class)->findAll();
        
        $json=$serializerInterface->serialize($offre,'json',['groups'=>'offres']);
        return new Response($json);
    }



    //afficher un seul appel d'offre

    /**
     * @Route("/detailoffre/{id}", name="detailoffre")
     */
    public function detailAppelOffre(int $id,EntityManagerInterface $em, SerializerInterface $serializerInterface): Response
    {
        $offre = $em->getRepository(AppelOffre::class)->find($id);
        
        $json=$serializerInterface->serialize($offre,'json',['groups'=>'offres']);
        return new JsonResponse($json);
    }




     /**
     * @Route("/registerOffre", name="registerOffre")
     */
    public function registerOffre( Request $request,SerializerInterface $serializer,EntityManagerInterface $manager){
        $Offre = new AppelOffre();


        $Offre->setNom($request->query->get("nom"));
        
        $Offre->setQuantite((int)$request->query->get("quantite"));
        $Offre->setBudget((float)$request->query->get("budget"));
        $Offre->setDescription($request->query->get("description"));
       // $Offre->setIdUtilisateur($request->query->get("idUtilisateur"));
       // $Offre->setIdCategorie($request->query->get("setIdCategorie"));

        $Offre->setDate(new DateTime());
        $Categorie=$manager->getRepository(Categorie::class)->findOneBy(array('id'=>$request->query->get("idCategorie")));
        $utilisateur=$manager->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("idUtilisateur")));

        $Offre->setIdUtilisateur($utilisateur);
        $Offre->setIdCategorie($Categorie);
        $manager->persist($Offre);
        $manager->flush();
        $json=$serializer->serialize($Offre,'json',['groups'=>'Offre']);
        return new Response($json);
    }



     /**
     * @Route("/updateOffre", name="updateOffre")
     */
    public function updateOffre( Request $request,serializerInterface $serializer,EntityManagerInterface $entityManager)
        {
            $Offre = new AppelOffre();
            $Offre=$entityManager->getRepository(AppelOffre::class)->findOneBy(array('id'=>$request->query->get("id")));
            $Offre->setNom($request->query->get("nom"));
        
            $Offre->setQuantite((int)$request->query->get("quantite"));
            $Offre->setBudget((float)$request->query->get("budget"));
            $Offre->setDescription($request->query->get("description"));
            $entityManager->persist($Offre);
            $entityManager->flush();

            return new Response("success");

        }



/**
* @Route("/deleteoffrejson", name="deleteoffrejson")
*/
public function deleteOffreee( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager
){

    $Offre=$entityManager->getRepository(AppelOffre::class)->findOneBy(array('id'=>$request->query->get("id")));

    $entityManager->remove($Offre);
    $entityManager->flush();
    return new Response("success");
   
}
}
