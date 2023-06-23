<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*
        $author = new Author();
        $author->setName("Albert Einstein");
        $author->setBio("Albert etait un con");
        $author->setCreatedAt(new DateTimeImmutable());
        $manager->persist($author);
        $manager->flush();
        */
    }
}
