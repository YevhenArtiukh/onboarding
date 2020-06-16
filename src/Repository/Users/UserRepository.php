<?php

namespace App\Repository\Users;

use App\Entity\Departments\Department;
use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Trainings\Training;
use App\Entity\UserResults\UserResult;
use App\Entity\Users\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findLastForGenerateLogin(string $string)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $this->createQueryBuilder('u')
            ->where('u.login LIKE :string')
            ->andWhere($qb->expr()->length('u.login').' = :length')
            ->setParameter('string', $string.'%')
            ->setParameter('length',strlen($string)+2)
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByOnboardingDivision(Onboarding $onboarding, Division $division)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin(Department::class, 'd', Join::WITH, 'u.department = d.id')
            ->leftJoin(Division::class, 'division', Join::WITH, 'd.division = division.id')
            ->leftJoin(Onboarding::class, 'o', Join::WITH, 'u.onboarding = o.id')
            ->where('o = :onboarding')
            ->andWhere('division = :division')
            ->setParameter('onboarding', $onboarding)
            ->setParameter('division', $division)
            ->getQuery()
            ->getResult();
    }

    public function findByEmailExceptUser(array $params)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->andWhere('u.id != :userID')
            ->setParameter('email', $params['email'])
            ->setParameter('userID',$params['userID'])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function EvaluationSurveyEmployeeCommand(int $day)
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.onboardingTrainings', 'ot')
            ->leftJoin('ot.training', 't')
            ->leftJoin('ot.onboarding', 'o')
            ->leftJoin('u.userResults', 'ur')
            ->where('t.isEvaluationSurvey = TRUE')
            ->andWhere('ur.id IS NULL')
            ->andWhere("DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(DATE_FORMAT(STR_TO_DATE(SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(o.days,';',3),':',-1),2,10), '%d.%m.%Y'), '%Y-%m-%d'), :day, 'day'), '%Y-%m-%d'), ot.day, 'day'), '%Y-%m-%d') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d')")
            ->setParameter('day', $day)
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
