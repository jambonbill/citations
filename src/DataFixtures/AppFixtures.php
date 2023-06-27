<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Factory\AuthorFactory;
use App\Factory\UserFactory;
use App\Factory\QuoteFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuthorFactory::createMany(10);
        UserFactory::createMany(10);
        QuoteFactory::createMany(25);
    }
}
