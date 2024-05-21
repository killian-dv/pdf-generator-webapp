<?php

namespace App\Controller;

use App\Entity\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les PDFs générés par l'utilisateur connecté
        $pdfs = $user->getPdfs()->toArray();

        // Trier les PDFs par ordre décroissant sur la date de création
        usort($pdfs, function ($a, $b) {
            return $b->getCreatedAt() <=> $a->getCreatedAt();
        });

        return $this->render('history/index.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }
}

