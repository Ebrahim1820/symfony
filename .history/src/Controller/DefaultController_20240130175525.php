<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;



class DefaultController extends AbstractController

{

    #[Route('/', name: 'app_homepage')]
   


    public function index(CommentRepository $repository): Response

    {
        
        //$comments = $repository->findBy( [], ['commentedAt'=> 'DESC']);
        $comments = $repository->findAllCommentedOrderByNewest();

        return $this->render('default/homepage.html.twig', ['comments'=>$comments,]);
        // $this->render('default/index.html.twig', [
        //     'controller_name' => 'DefaultController',
        // ]);
    }

    #[Route('/news/new')]
    public function new(EntityManagerInterface $entityManager){

        die('TODO');

             return new Response(sprintf('Hallo! The shiny new comment is <br> id %s,<br> name %s,<br> slug %s <br> comment %s',
             $comment->getId(),
             $comment->getName(),
             $comment->getSlug(),
             $comment->getComment()
             )
            );
            }


    #[Route('/news/{slug}', name: 'article_show')]
    public function show(Comment $comment) //PostRepository $postRepository
    {
      
        // find posts related to the comment
        // $posts = $postRepository->findBy([ 'comment' => $comment ]);
        
        // Your controller logic here
        return $this->render('default/show.html.twig', [

            'article'=>$comment,
           

        ]);
    }



    ################### TOGGEL HEART #######################

    #[Route('/news/{slug}/heart', name: 'article_toggle_heart', methods:'POST')]
    public function toggelArticleHeart(Comment $comment, LoggerInterface $logger, EntityManagerInterface $em){

        // $comment->setHeartCount($comment->getHeartCount() + 1);
        $comment->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted');

        // JasonResponse(['hearts'=> rand(5, 100)]);
        return  $this->json([ 'hearts' => $comment->getHeartCount() ]);

    }


 
}
