<?php
namespace App\Service;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ToggleArticleHeart extends AbstractController
{

     ################### TOGGEL HEART #######################
     private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }
    
     public function toggleArticleHeart(Comment $comment){
 
         // $comment->setHeartCount($comment->getHeartCount() + 1);
         $comment->incrementHeartCount();
         $this->em->flush();
 
         $this->logger->info('Article is being hearted');
 
         // JasonResponse(['hearts'=> rand(5, 100)]);
         return  $this->json([ 'hearts' => $comment->getHeartCount() ]);
 
     }
}