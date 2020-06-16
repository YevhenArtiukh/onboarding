<?php

namespace App\Repository\Onboardings;

use App\Entity\Onboardings\Onboarding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Onboarding|null find($id, $lockMode = null, $lockVersion = null)
 * @method Onboarding|null findOneBy(array $criteria, array $orderBy = null)
 * @method Onboarding[]    findAll()
 * @method Onboarding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnboardingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Onboarding::class);
    }

    public function getLastOnboardingForCopy(Onboarding $onboarding)
    {
        return $this->createQueryBuilder('o')
            ->where('o != :onboarding')
            ->setParameter('onboarding', $onboarding)
            ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function trainingScheduleGeneral()
    {
        return $this->createQueryBuilder('o')
            ->where("DATE_FORMAT(DATE_ADD(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), 5, 'day'), '%Y-%m-%d') > DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d')")
            ->orderBy("STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y')", 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function onboardingCoachCommand(int $day)
    {
        return $this->createQueryBuilder('o')
            ->where("DATE_FORMAT(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), '%Y-%m-%d') = DATE_FORMAT(DATE_ADD(CURRENT_DATE(), :day, 'day'), '%Y-%m-%d')")
            ->setParameter('day', $day)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Onboarding[] Returns an array of Onboarding objects
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
    public function findOneBySomeField($value): ?Onboarding
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
