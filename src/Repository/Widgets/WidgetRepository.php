<?php

namespace App\Repository\Widgets;

use App\Entity\Widgets\Widget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Widget|null find($id, $lockMode = null, $lockVersion = null)
 * @method Widget|null findOneBy(array $criteria, array $orderBy = null)
 * @method Widget[]    findAll()
 * @method Widget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WidgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Widget::class);
    }

    /**
     * @param array $params
     * @return Widget[] Returns an array of Widget objects
     */
    public function findByRoleAndDefaultPosition(array $params)
    {
        $qb = $this->createQueryBuilder('qb');

        return $this->createQueryBuilder('w')
            ->where('w.roleID = :roleID')
            ->andWhere($qb->expr()->isNotNull('w.defaultPosition'))
            ->setParameter('roleID', $params['roleID'])
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Widget[] Returns an array of Widget objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Widget
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
