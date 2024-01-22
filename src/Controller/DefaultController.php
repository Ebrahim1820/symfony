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
        $comments = [
            'First item to check',
            'This is second part',
            'This is the third part',
        ];
        // Your controller logic here
        return $this->render('default/show.html.twig', [

            'title' => ucwords(str_replace('-', ' ', $slug)),

            'comments'=>$comments, 

        ]);
    }

 
}
