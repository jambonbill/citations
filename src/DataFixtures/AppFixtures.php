<?php

namespace App\DataFixtures;

use App\Entity\User as EntityUser;
use App\Entity\Author as EntityAuthor;
use App\Entity\Quote as EntityQuote;

use App\Factory\AuthorFactory;
use App\Factory\UserFactory;
use App\Factory\QuoteFactory;
use App\Repository\AuthorRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $authorRepo;
    private $userRepo;

    public function __construct(AuthorRepository $arepo, UserRepository $urepo)
    {
        echo __FUNCTION__."()\n";
        $this->authorRepo=$arepo;
        $this->userRepo=$urepo;
    }

    public function load(ObjectManager $manager): void
    {
        //$this->userrepo=new UserRepository()
        
        $this->createUsers($manager);
        $manager->flush();//flush, so we can fetch users during the next step

        $this->createAuthors($manager);
        $manager->flush();//...

        $this->createCitations($manager);

        UserFactory::createMany(3);
        
        AuthorFactory::createMany(1,function(){
            return [
                'createdBy'=> UserFactory::random()
            ];
        });

        /*
        QuoteFactory::createMany(3,function(){
            return [
                'author'=> AuthorFactory::random(),
                'createdBy'=> UserFactory::random()
            ];
        });
        */

        $manager->flush();
    }

    public function createUsers(ObjectManager $manager): void
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
        $user->setRoles(["ROLE_ADMIN"]);
        
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

 
        
    }

    public function createAuthors(ObjectManager $manager):void
    {
        echo __FUNCTION__."()\n";
        
        $users=$this->userRepo->findAll();
        //dd($users);

        $lines=file(__DIR__."/authors.md");
        foreach ($lines as $line) {
            
            if (preg_match("/^-/", $line)) {
                $line=preg_replace("/^-[ ]/","",$line);
                $line=trim($line);
                //echo "$line\n";
                $dat=explode("|", $line);
                
                if(count($dat)<2)continue;
                
                $author = new EntityAuthor();
                $author->setName(trim($dat[0]));
                $author->setBio(trim($dat[1]));
                //$user=new EntityUser();
                
                $author->setCreatedBy($users[rand(0,count($users)-1)]);
                //'question' => QuestionFactory::new()->unpublished()->create(),
                $manager->persist($author);
            }
        }
    }

    
    /**
     * Load and inject some french quotes
     *
     * @return void
     */
    public function createCitations(ObjectManager $manager):void
    {
        echo __FUNCTION__."()\n";

        $users=$this->userRepo->findBy(['isVerified'=>1]);
        //dd($users);
        $authors=$this->authorRepo->findAll();
        

        $lines=file(__DIR__."/quotes.md");
        foreach ($lines as $line) {
            
            if (preg_match("/^-/", $line)) {
                $line=preg_replace("/^-[ ]/","",$line);
                $quoteStr=trim($line);
                
                $q = new EntityQuote();
                $q->setData($quoteStr);
                $q->setCreatedBy($users[rand(0,count($users)-1)]);
                shuffle($authors);
                $q->setAuthor($authors[0]);
                $manager->persist($q);
            }
        }

    }
}
