<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN_POST')]
class PostAdminController extends AbstractController
{
     
    #[Route('/admin/post', name: 'app_post_admin')]
   
   
    public function index(PostRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $q = $request->query->get('q');

        $queryBuilder = $repository->getWithSearchQueryBuilder($q);
        // foreach($posts as $post){
        //     print_r($post);
        // }

        $pagination = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1), 10 );

        
        return $this->render('post_admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
