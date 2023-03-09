<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Options;
use App\Entity\Facture;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
 
   
   

      /**
     * @Route("/exel", name="exel")
     */
    public function exel(EntityManagerInterface $em)
    {
        $spreadsheet = new Spreadsheet();

        // Get the active worksheet
        $worksheet = $spreadsheet->getActiveSheet();
    
        // Add data to the worksheet
        $worksheet->setCellValue('A1', 'Column 1');
        $worksheet->setCellValue('B1', 'Column 2');
        $worksheet->setCellValue('C1', 'Column 3');
    
        $data = [
            ['Data 1', 'Data 2', 'Data 3'],
            ['Data 4', 'Data 5', 'Data 6'],
            ['Data 7', 'Data 8', 'Data 9'],
        ];
    
        $row = 2;
        foreach ($data as $rowData) {
            $column = 'A';
            foreach ($rowData as $value) {
                $worksheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }
    
        // Create a new response object
        $response = new \Symfony\Component\HttpFoundation\Response();
    
        // Set the response headers
        $headers = $response->headers;
        $headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $headers->set('Content-Disposition', $headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'export.xlsx'
        ));
        $headers->set('Cache-Control', 'max-age=0');
    
        // Create a new writer object
        $writer = new Xlsx($spreadsheet);
    
        // Write the spreadsheet to a PHP output stream
        $writer->save('php://output');
    
        return $response;

    }
}