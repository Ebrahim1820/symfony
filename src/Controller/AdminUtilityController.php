<?php

declare(strict_types=1);

namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminUtilityController extends AbstractController
{
    
    #[Route("/admin/utility/users", methods:["GET"])]

 
    public function getUsersApi(UserRepository $userRepository)
    {

        $users = $userRepository->findAllEmailAlphabetical();

        return $this->json([
            'users' => $users
        ], 200, [], ['groups'=>['main']]);

    }

    
}
