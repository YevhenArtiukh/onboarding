<?php

namespace App\Repository\AnnualSchedules;

use App\Entity\AnnualSchedules\AnnualSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnnualSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnualSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnualSchedule[]    findAll()
 * @method AnnualSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnualScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnualSchedule::class);
    }

    // /**
    //  * @return AnnualSchedule[] Returns an array of AnnualSchedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnnualSchedule
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
