<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Subscription;

class SubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/subscription', name: 'app_subscription')]
    public function index(): Response
    {
        $subscriptions = $this->entityManager->getRepository(Subscription::class)->findAll();


        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    #[Route('/subscription/{id}/change', name: 'app_change_subscription', methods: ['POST'])]
    public function changeSubscription(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $subscription = $entityManager->getRepository(Subscription::class)->find($id);

        if (!$subscription) {
            throw $this->createNotFoundException('Cet abonnement n\'existe pas.');
        }

        $user->setSubscription($subscription);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre abonnement a été changé avec succès.');

        return $this->redirectToRoute('app_subscription');
    }
}
