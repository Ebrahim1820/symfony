<?php

namespace App\Repository;

use App\Entity\Comment;
use APP\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
// use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder;
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
        // To use the logic from createNonDeletedCriteria
        // We can call that like this 
        // $this->createQueryBuilder('a')
        //     ->addCriteria(self::createNonDeletedCriteria());
      
            return $this->addIsPublishedQueryBuilder()
           ->orderBy('a.commentedAt', 'DESC')
           ->getQuery()
           ->getResult()
            // ->leftJoin('a.tags', 't')
            // ->addSelect('t')
       ;
   }

   public static function createNonDeletedCriteria()
   {
     return Criteria::create()
     ->andWhere(Criteria::expr()->eq('isDeleted', false))
     ->orderBy([ 'createdAt' => 'DESC' ]);
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

    private function addIsPublishedQueryBuilder(QueryBuilder $qb= null)
    {
        return $this->getOrCreateQueryBuilder($qb)  
            ->andWhere('a.commentedAt IS NOT NULL'); 
    }

    private function getOrCreateQueryBuilder(?QueryBuilder $qb=null)
    {
        return $qb ?: $this->createQueryBuilder('a');
    }

    /**
     * @return Comment[]
     */
    public function findAllPublishedLastWeekByAuthor(User $author): array
    {
        return $this-> createQueryBuilder('c')
        ->andWhere('c.author = :author')
        ->andWhere('c.commentedAt > :week_ago')
        ->setParameter('author', $author)
        ->setParameter('week_ago', new \DateTime('-1  week'))
        ->getQuery()
        ->getResult()
        ;
    }
}
