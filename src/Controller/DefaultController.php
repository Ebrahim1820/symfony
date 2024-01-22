<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController

{
   
    #[Route('/default1/', name: 'default1')]
   


    public function index(): Response

    {
        
   
        return new Response('First output');
        // $this->render('default/index.html.twig', [
        //     'controller_name' => 'DefaultController',
        // ]);
    }

    

    #[Route('/news/{slug}', name: 'home')]
    public function show($slug)
    {
      
        // Your controller logic here
        return new Response(sprintf('Future page to show %s', $slug));
    }

 
}
