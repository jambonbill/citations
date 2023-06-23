<?php

namespace App\DataFixtures;

use App\Entity\Author as EntityAuthor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Author extends Fixture
{
    //https://blog.gary-houbre.fr/developpement/symfony/symfony-comment-mettre-en-place-des-fixtures
    public function load(ObjectManager $manager): void
    {
        $entity = new EntityAuthor();
        $entity->setName("Steve jobs");
        $entity->setBio("Steve etait un con");
        $manager->persist($entity);

        $author = new EntityAuthor();
        $author->setName("Albert Einstein");
        $author->setBio("né le 14 mars 1879 à Ulm, Wurtemberg, et mort le 18 avril 1955 à Princeton, est un physicien qui fut successivement allemand");
        
        $manager->persist($author);


        $author = new EntityAuthor();
        $author->setName("David LEGRAND");
        $author->setBio("Formateur CDA");
        $manager->persist($author);

        $manager->flush();
    }
}
