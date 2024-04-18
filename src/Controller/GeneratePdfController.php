<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\GeneratePdfForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate/pdf', name: 'generate_pdf')]
    public function generatePdf(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a form
        $form = $this->createForm(GeneratePdfForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get the value of the form
            $pdfName = $form->getData()['pdfName'];
            $url = $form->getData()['url'];

            // Créer une instance HttpClient
            $client = HttpClient::create();

            // Envoyer la requête POST à l'URL spécifiée avec le paramètre 'url'
            $response = $client->request('POST', 'http://127.0.0.1:8001/gotenberg/convert', [
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
                'body' => [
                    'url' => $url,
                ]
            ]);

            $content = $response->getContent();

            // generate a random file name
            $randomFileName = uniqid('pdf_') . '.pdf';

            // path
            $filePath = 'uploads/' . $randomFileName;

            // Download the PDF
            $pdf = fopen($filePath, 'w');
            fwrite($pdf, $content);
            fclose($pdf);


            // add the pdf in the pdf entity
            $pdf = new Pdf();
            $pdf->setTitle($pdfName);
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $pdf->setPath($filePath);

            // save the pdf in the database
            $entityManager->persist($pdf);
            $entityManager->flush();

        }

        // Afficher le formulaire
        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
