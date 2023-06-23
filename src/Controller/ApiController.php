<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use Symfony\Component\Serializer\Encoder\JsonEncoder;
//use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
//use Symfony\Component\Serializer\Serializer;

class ApiController extends AbstractController
{

    //private $normaliser=null;
    //private $serializer=null;

    public function __construct()
    {
        //$this->normaliser=new ObjectNormalizer();        
        //$this->serializer=new Serializer([new ObjectNormalizer()],[new JsonEncoder()]);
    }
    
    #[Route('/api', name: 'api_root')]
    public function root(): Response
    {
        $data=["hello"=>"api"];
        //$data['routes']=['/api/quotes'];
        return $this->json($data);
    }


    #[Route('/api/test', name: 'api_test')]
    public function test(QuoteRepository $repo): Response
    {
        $q=$repo->find(8);
        //$author=$q->author
        //echo $q->getAuthor();exit;
        //dd($q);
        //dd($q->author);
        $dat=[];
        $dat['quote']=$q->getData();
        $dat['author']=$q->getAuthor()->getName();
        return $this->json($dat);
    }




    #[Route('/api/quotes', name: 'api_quotes')]
    public function quotes(QuoteRepository $repo): Response
    {
        $quotes=$repo->findLast();
        $json=[];
        
        //$jsonContent = $serializer->serialize($quotes, 'json');
        return $this->json($json);
    }

    
    #[Route('/api/quote/{id}', name: 'api_quote')]
    public function quote(int $id, QuoteRepository $repo): Response
    {
        $quote=$repo->find($id);
        
        //$data['quote']=$this->serializer->serialize($quote, 'json', ['json_encode_options' => \JSON_PRESERVE_ZERO_FRACTION]);

        $data['quote']=$quote;
        return $this->json($data);
    }

    
    #[Route('/api/authors', name: 'api_authors')]
    public function authors(AuthorRepository $repo): Response
    {
        $authors=$repo->findAll();
        
        $data=[];
        $data['authors']=[];
        foreach($authors as $author){
            
            $dat['name']=$author->getName();
            $dat['bio']=$author->getBio();
            $dat['slug']=$author->getSlug();
            $dat['quotes']=[];//todo
            $data['authors'][]=$dat;
        }
        
        
        return $this->json($data);
    }
    
}
