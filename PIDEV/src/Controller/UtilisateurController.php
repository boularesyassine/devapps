<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\ForgetPasswordType;
use App\Form\NewPasswordType;
use App\Form\SetCodeType;

use App\Form\UpdateUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;
class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }


    /**
     * @Route("/Utilisateurs", name="displayusers")
     */
    public function afficherusers(): Response
    {
       
        $Utilisateurs= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();
        return $this->render('Utilisateur/index.html.twig', [
            'b'=>$Utilisateurs
        ]);
    }

    /**
     * @Route("/addUtilisateur", name="addUtilisateur")
     */
    public function addUtilisateur(Request $request,\Swift_Mailer $mailer): Response
    {
      
       $Utilisateur=new Utilisateur();
       $form=$this->createForm(UtilisateurType::class,$Utilisateur);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $message = (new \Swift_Message('Hello this mail will be changed by code verification'))
        ->setFrom('mejdi.mohamed@esprit.tn')
        ->setTo($Utilisateur->getEmail())
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/regostration.html.twig',
            ),
            'text/html'
        )

    ;

    $mailer->send($message);
         $em = $this->getDoctrine()->getManager();
           $em->persist($Utilisateur);
           $em->flush();

           return $this->redirectToRoute('displayusers');
       }
       else
       return $this->render('Utilisateur/createUtilisateur.html.twig',['f'=>$form->createView()]);

    }




    /**
     * @Route("/modifierUser/{id}", name="modifierUser")
     */
    public function modifierUser(Request $request,$id): Response
    {
      
       $utilisateur=$this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($id);
       $form=$this->createForm(UpdateUtilisateurType::class,$utilisateur);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
    
       
           $em = $this->getDoctrine()->getManager();
           
           $em->flush();

           return $this->redirectToRoute('displayusers');
       }
       else
       return $this->render('utilisateur/modifier.html.twig',['f'=>$form->createView()]);

    }

    /**
* @Route("/deleteuser", name="deleteuser")
*/
public function deleteUser( 
    Request $request,
    EntityManagerInterface $entityManager

){

$utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));

$entityManager->remove($utilisateur);
$entityManager->flush();
$Utilisateurs= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();
return $this->render('Utilisateur/index.html.twig', [
    'b'=>$Utilisateurs
]);
}



    /**
     * @Route("/forgetpaasword", name="forget_password")
     */
    public function forget(Request $request,\Swift_Mailer $mailer): Response
    {
      
       $form=$this->createForm(ForgetPasswordType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $data = $form->getData();
        $email=$data["email"];
  
        $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('email'=>$email));
        if($Utilisateur)
        {

        
        $random_number = rand(1000, 9999);
        $Utilisateur->setCode($random_number);
        $em = $this->getDoctrine()->getManager();
           
        $em->flush();

      
        $message = (new \Swift_Message('forget password'))
        ->setFrom('mejdi.mohamed@esprit.tn')
        ->setTo($Utilisateur->getEmail())
        ->setBody($random_number." est votre code de recuperation mot de passe")

    ;

      $mailer->send($message);
      return $this->redirectToRoute('setcode', ['id' => $Utilisateur->getid()]);
    }
    else
    {
        return $this->render('utilisateur/forgetpassword.html.twig',['f'=>$form->createView()]);

    }
    }
    
       return $this->render('utilisateur/forgetpassword.html.twig',['f'=>$form->createView()]);

    }


    /**
     * @Route("/setcode", name="setcode")
     */
    public function secode(Request $request): Response
    {
      
        $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));
       
       $form=$this->createForm(SetCodeType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $data = $form->getData();
        $code=$data["code"];
        if($code == $Utilisateur->getcode())
        {
            return $this->redirectToRoute('newpassword', ['id' => $Utilisateur->getid()]);

        }
        else
        {
            return $this->render('utilisateur/setcode.html.twig',['f'=>$form->createView()]);

        }
    }
    
       return $this->render('utilisateur/setcode.html.twig',['f'=>$form->createView()]);

    }

 /**
     * @Route("/newpaasword", name="newpassword")
     */
    public function newpassword(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
      
        $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));

       $form=$this->createForm(NewPasswordType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
        $data = $form->getData();
        $password=$data["password"];
        $Utilisateur->setPassword( $userPasswordEncoder->encodePassword(
            $Utilisateur,
            $form->get('password')->getData()
        ));
        $em = $this->getDoctrine()->getManager();
        $em->persist($Utilisateur);
        $em->flush();
        return $this->redirectToRoute('app_login');

    }
    
       return $this->render('utilisateur/password.html.twig',['f'=>$form->createView()]);

    }


     /**
     * @Route("/bloquer", name="bloquer")
     */
    public function bloquer(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
      
        $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));
        if($Utilisateur->getBloquer() == 1)
{
    $Utilisateur->setBloquer(0);
}
else
{
    $Utilisateur->setBloquer(1);
}
        
            $em = $this->getDoctrine()->getManager();
           
            $em->flush();
            return $this->redirectToRoute('displayusers');

    }





























/**
     * @Route("/Utilisateurlist",name="Utilisateurlist")
     */

     public function getUtilisateurs(SerializerInterface $serializer ){
        $Utilisateurs = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();
      
        $json=$serializer->serialize($Utilisateurs,'json',['groups'=>'Utilisateur']);
        return new Response($json);
    }
    /**
     * @Route("/registerUtilisateur", name="registerUtilisateur")
     */
    public function registerUtilisateur( Request $request,SerializerInterface $serializer,
    UserPasswordEncoderInterface $encoder,
                                  EntityManagerInterface $manager){
        $Utilisateur = new Utilisateur();

        $Utilisateur->setNom($request->query->get("nom"));
        $Utilisateur->setPrenom($request->query->get("prenom"));
        $Utilisateur->setPassword($encoder->encodePassword($Utilisateur,$request->query->get("password")));
        $Utilisateur->setEmail($request->query->get("email"));
        $Utilisateur->setAdresse($request->query->get("adresse"));
        $Utilisateur->setUsername($request->query->get("username"));
        $Utilisateur->setPhoto($request->query->get("photo"));

        $Utilisateur->setAge(new DateTime($request->query->get("age")));
   
        $role='ROLE_USER';
        $Utilisateur->setRoles($role);
        $manager->persist($Utilisateur);
        $manager->flush();
        $json=$serializer->serialize($Utilisateur,'json',['groups'=>'Utilisateur']);
        return new Response($json);
    }


    /**
    * @Route("/searchedutilisateur", name="searchedutilisateur")
    */
    public function searched(Request $request, serializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $bacRepository = $em->getRepository(Utilisateur::class);
        // deserialize the form data into an array
       
        // retrieve the search query from the 'query' attribute
        $queryBuilder = $bacRepository->createQueryBuilder('b');
 
        $search = $request->query->get('search');
 
 
 
 
        $queryBuilder->where('b.nom LIKE :search OR b.prenom LIKE :search OR b.email LIKE :search OR b.adresse LIKE :search  OR b.username LIKE :search')
            ->setParameter('search', "%$search%");
 
 
       
 
        $result = $queryBuilder->getQuery()->getResult();
        $json = $serializer->serialize($result, 'json', ['groups' => 'Utilisateur']);
 
        return new Response($json);
       
    }
 



       /**
     * @Route("/loginUtilisateur", name="login_Utilisateur")
     */
    public function loginapi( Request $request,serializerInterface $serializer, UserPasswordEncoderInterface $encoder )
    {


        $Utilisateur=new Utilisateur();

        $hash =$encoder->encodePassword($Utilisateur,$request->query->get("password"));
        $Utilisateur->setPassword($hash);
        $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('username'=>$request->query->get("login")));
        $UtilisateurCheck = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('password'=>$Utilisateur->getPassword()));

        if($encoder->isPasswordValid($Utilisateur,$request->query->get("password"))) {
            $json = $serializer->serialize($Utilisateur, 'json');
            return new Response($json);
        }

        return new Response('Bad credentials');

    }






   /**
     * @Route("/updateUtilisateur", name="updateUtilisateur")
     */
    public function updateUtilisateur( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder )
        {
    $Utilisateur = new Utilisateur();
    $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));
    $Utilisateur->setNom($request->query->get("nom"));
    $Utilisateur->setPrenom($request->query->get("prenom"));
    $Utilisateur->setPassword($encoder->encodePassword($Utilisateur,$request->query->get("password")));
    $Utilisateur->setEmail($request->query->get("email"));
    $Utilisateur->setAdresse($request->query->get("adresse"));
    $Utilisateur->setUsername($request->query->get("username"));
    $Utilisateur->setPhoto($request->query->get("photo"));
$entityManager->persist($Utilisateur);
$entityManager->flush();

 return new Response("success");

}

/**
* @Route("/deleteUtilisateur", name="deleteuer")
*/
public function deleteUtilisateur( 
        Request $request,
        serializerInterface $serializer,
        EntityManagerInterface $entityManager

){

    $Utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id'=>$request->query->get("id")));
    $em=$this->getDoctrine()->getManager();
    $em->remove($Utilisateur);
    $em->flush();
    return new Response("success");
   
}
}








