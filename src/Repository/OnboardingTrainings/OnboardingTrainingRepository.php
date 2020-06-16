<?php

namespace App\Repository\OnboardingTrainings;

use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Trainings\Training;
use App\Entity\Users\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method OnboardingTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnboardingTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnboardingTraining[]    findAll()
 * @method OnboardingTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnboardingTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnboardingTraining::class);
    }

    public function checkConflictTrainings(int $day, \DateTimeInterface $time, Onboarding $onboarding, int $duration, ?int $id, ?Division $division)
    {
        $qb = $this->createQueryBuilder('ot')
            ->leftJoin(Training::class, 't', Join::WITH, 'ot.training = t.id')
            ->where('ot.day = :day')
            ->andWhere('ot.onboarding = :onboarding')
            ->andWhere("
                (
                    DATE_FORMAT(:time, '%H:%i') < ot.time AND 
                    DATE_FORMAT((DATE_ADD(:time, :duration, 'minute')), '%H:%i') > ot.time
                ) OR
                (
                    DATE_FORMAT(:time, '%H:%i') >= ot.time AND 
                    DATE_FORMAT((DATE_ADD(:time, :duration, 'minute')), '%H:%i') < DATE_FORMAT((DATE_ADD(ot.time, t.time, 'minute')), '%H:%i')
                ) OR
                (
                    DATE_FORMAT(:time, '%H:%i') > ot.time AND 
                    DATE_FORMAT((DATE_ADD(:time, :duration, 'minute')), '%H:%i') > DATE_FORMAT((DATE_ADD(ot.time, t.time, 'minute')), '%H:%i') AND 
                    DATE_FORMAT((DATE_ADD(ot.time, t.time, 'minute')), '%H:%i') > DATE_FORMAT(:time, '%H:%i')
                ) OR
                (
                    DATE_FORMAT(:time, '%H:%i') < ot.time AND 
                    DATE_FORMAT((DATE_ADD(:time, :duration, 'minute')), '%H:%i') > DATE_FORMAT((DATE_ADD(ot.time, t.time, 'minute')), '%H:%i')
                )
            ")
            ->setParameter('day', $day)
            ->setParameter('onboarding', $onboarding)
            ->setParameter('time', $time)
            ->setParameter('duration', $duration);

        if ($id) {
            $qb
                ->andWhere('ot.id != :id')
                ->setParameter('id', $id);
        }

        if($division) {
            $qb
                ->andWhere('(ot.division = :division OR ot.division IS NULL)')
                ->setParameter('division', $division);
        }

        return $qb->getQuery()->getResult();
    }

    public function findGeneralInOnboarding(Onboarding $onboarding)
    {
        return $this->createQueryBuilder('ot')
            ->leftJoin(Training::class, 't', Join::WITH, 'ot.training = t.id')
            ->leftJoin(Onboarding::class, 'o', Join::WITH, 'ot.onboarding = o.id')
            ->where('t.isAdditional = false')
            ->andWhere('t.kindOfTraining = :kindOfTraining')
            ->andWhere('o = :onboarding')
            ->setParameter('onboarding', $onboarding)
            ->setParameter('kindOfTraining', 'general')
            ->getQuery()
            ->getResult();
    }

    public function findDivisionInOnboarding(Onboarding $onboarding, Division $division)
    {
        return $this->createQueryBuilder('ot')
            ->leftJoin(Training::class, 't', Join::WITH, 'ot.training = t.id')
            ->leftJoin(Onboarding::class, 'o', Join::WITH, 'ot.onboarding = o.id')
            ->leftJoin(Division::class, 'd', Join::WITH, 'ot.division = d.id')
            ->where('o = :onboarding')
            ->andWhere('d = :division')
            ->andWhere('t.kindOfTraining = :kindOfTraining')
            ->setParameter('onboarding', $onboarding)
            ->setParameter('division', $division)
            ->setParameter('kindOfTraining', 'division')
            ->getQuery()
            ->getResult();
    }

    public function findAllNotInOnboardingForUser(Onboarding $onboarding, User $user)
    {
        return $this->createQueryBuilder('ot')
            ->innerJoin('ot.users', 'u', Join::WITH, 'u = :user')
            ->where('ot.onboarding != :onboarding')
            ->setParameter('user', $user)
            ->setParameter('onboarding', $onboarding)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return OnboardingTraining[] Returns an array of OnboardingTraining objects
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
    public function findOneBySomeField($value): ?OnboardingTraining
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
