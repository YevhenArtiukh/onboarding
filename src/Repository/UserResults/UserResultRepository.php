<?php

namespace App\Repository\UserResults;

use App\Entity\UserResults\UserResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserResult[]    findAll()
 * @method UserResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResult::class);
    }

    // /**
    //  * @return UserResultsQuery[] Returns an array of UserResultsQuery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserResultsQuery
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
