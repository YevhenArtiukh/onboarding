<?php

namespace App\Repository\UserOnboardingTrainings;

use App\Entity\UserOnboardingTrainings\UserOnboardingTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserOnboardingTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOnboardingTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOnboardingTraining[]    findAll()
 * @method UserOnboardingTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOnboardingTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOnboardingTraining::class);
    }

    // /**
    //  * @return UserOnboardingTrainingQuery[] Returns an array of UserOnboardingTrainingQuery objects
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
    public function findOneBySomeField($value): ?UserOnboardingTrainingQuery
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
