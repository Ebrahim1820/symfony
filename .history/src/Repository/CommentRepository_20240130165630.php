<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

   /**
    * @return Comment[] Returns an array of Comment objects
    */
   public function findAllCommentedOrderByNewest(): array
   {
      
            return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.commentedAt', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Comment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // private function addIsPublishedQueryBuilder(QueryBuilder $qb= null)
    // {
    //     return $this->getOrCreateQueryBuilder($qb)  
    //         ->andWhere('a.commentedAt IS NOT NULL'); 
    // }

    // private function getOrCreateQueryBuilder(QueryBuilder $qb=null)
    // {
    //     return $qb ?: $this->createQueryBuilder('a');
    // }
}
