<?php

namespace App\DataFixtures;

use App\Entity\User as EntityUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class User extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //./bin/console security:hash-password 
        $pwd='$2y$13$HFGr4Mp58s6S5JQdLNqTCOsyKnzKoMPJz9mKkR3gh2gnIm1G1py9K';//1234

        $user = new EntityUser();
        $user->setFirstName("Bob");
        $user->setLastName("Administrator");
        $user->setEmail("admin@citations.fr");
        $user->setPassword($pwd);
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DateTimeImmutable);
        $user->setRoles(["ROLE_ADMIN, ROLE_SUPERADMIN"]);
        
        $manager->persist($user);

        $user = new EntityUser();
        $user->setEmail("moderator@citations.fr");
        $user->setFirstName("Robert");
        $user->setLastName("Bidouillon");
        $user->setPassword($pwd);
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DateTimeImmutable);
        $user->setRoles(["ROLE_MODERATOR"]);        
        $manager->persist($user);

        //
 
        $manager->flush();
    }
}
