<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
