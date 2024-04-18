<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscription;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $subscription1 = new Subscription();
        $subscription1->setTitle('Découverte');
        $subscription1->setDescription('Abonnement de découverte');
        $subscription1->setPdfLimit(3);
        $subscription1->setPrice(0);
        $subscription1->setMedia('assets/decouverte_media.png');

        $manager->persist($subscription1);

        $subscription2 = new Subscription();
        $subscription2->setTitle('Basique');
        $subscription2->setDescription('Abonnement basique');
        $subscription2->setPdfLimit(10);
        $subscription2->setPrice(5);
        $subscription2->setMedia('assets/basique_media.png');

        $manager->persist($subscription2);

        $subscription3 = new Subscription();
        $subscription3->setTitle('Premium');
        $subscription3->setDescription('Abonnement premium');
        $subscription3->setPdfLimit(50);
        $subscription3->setPrice(10);
        $subscription3->setMedia('assets/premium_media.png');

        $manager->persist($subscription3);


        $manager->flush();
    }
}
