<?php

namespace App\Repository\PresenceParticipants;

use App\Entity\PresenceParticipants\PresenceParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PresenceParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresenceParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresenceParticipant[]    findAll()
 * @method PresenceParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresenceParticipant::class);
    }

    // /**
    //  * @return PresenceParticipant[] Returns an array of PresenceParticipant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PresenceParticipant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
