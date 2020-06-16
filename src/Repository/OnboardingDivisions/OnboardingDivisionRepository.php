<?php

namespace App\Repository\OnboardingDivisions;

use App\Entity\OnboardingDivisions\OnboardingDivision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnboardingDivision|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnboardingDivision|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnboardingDivision[]    findAll()
 * @method OnboardingDivision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnboardingDivisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnboardingDivision::class);
    }

    // /**
    //  * @return OnboardingDivision[] Returns an array of OnboardingDivision objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OnboardingDivision
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
