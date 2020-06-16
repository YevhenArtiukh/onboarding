<?php

namespace App\Repository\TrainingAttachments;

use App\Entity\TrainingAttachments\TrainingAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrainingAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingAttachment[]    findAll()
 * @method TrainingAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingAttachment::class);
    }

    // /**
    //  * @return TrainingAttachment[] Returns an array of TrainingAttachment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainingAttachment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
