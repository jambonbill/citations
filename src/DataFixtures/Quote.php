<?php

namespace App\DataFixtures;

use App\Entity\Quote as EntityQuote;
use App\Repository\QuoteRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Quote extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //$manager->getRepository(QuoteRepository $repo);//to continue

        $entity = new EntityQuote();
        //$entity->setAuthor()
        $entity->setData("Il vaut mieux une couille sur un mur qu'un nez dans une chaussure");
        //$entity->setInfo()
        $entity->setCreatedAt(new \DateTimeImmutable());
        
        $manager->persist($entity);

        $manager->flush();
    }
}
