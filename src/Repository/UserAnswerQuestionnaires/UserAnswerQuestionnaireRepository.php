<?php

namespace App\Repository\UserAnswerQuestionnaires;

use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserAnswerQuestionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAnswerQuestionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAnswerQuestionnaire[]    findAll()
 * @method UserAnswerQuestionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAnswerQuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAnswerQuestionnaire::class);
    }

    // /**
    //  * @return UserAnswerQuestionnaire[] Returns an array of UserAnswerQuestionnaire objects
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
    public function findOneBySomeField($value): ?UserAnswerQuestionnaire
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
