<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AccountController extends BaseController
{
    #[Route('/account', name: 'app_account')]

    public function index(LoggerInterface $logger): Response
    {
      
     
        $logger->debug('Checking account page for'. $this->getUser()->getEmail());
        return $this->render('account/index.html.twig', [
           
        ]);
    }

    // define an API
    #[Route('/api/account' , name:'api_account')]
    public function accountApi(){
        // will return the JSON representation of whoever is logged in
        $user = $this->getUser();

        return $this->json($user, 200, [],[
            'groups'=>['main']
        ]);


    }
}
