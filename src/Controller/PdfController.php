<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Options;
use App\Entity\Facture;


use App\Repository\DonRepository;
 
class PdfController extends AbstractController
{
  
    /**
     * @Route("/pdf", name="pdf")
     */
    public function pdf(EntityManagerInterface $em)
    {
        {
            $don=$em->getRepository(Facture::class)->findAll();
            
    
            // On définit les options du PDF
            $pdfOptions = new Options();
            // Police par défaut
            $pdfOptions->set('defaultFont', 'Arial');
            $pdfOptions->setIsRemoteEnabled(true);
    
            // On instancie Dompdf
            $dompdf = new Dompdf($pdfOptions);
            
    
            // On génère le html
            $html = $this->renderView('pdf/index.html.twig',
                ['b'=>$don ]);
           
    //
    
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            // On génère un nom de fichier
            $fichier = 'Tableau des dons.pdf';
    
            // On envoie le PDF au navigateur
            $dompdf->stream($fichier, [
                'Attachment' => true
            ]);
    
            return new Response();
        }
    }
 
   
   
}