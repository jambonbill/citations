<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends AbstractController
{
    #[Route('/quotes', name: 'quotes')]
    public function quotes(): Response
    {
        $data=[];
        $data['hello']='world';
        return $this->json($data);
    }

    #[Route('/authors', name: 'quotes')]
    public function authors(): Response
    {
        $data=[];
        $data['authors']=[];
        return $this->json($data);
    }
    
}
