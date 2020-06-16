<?php

namespace App\Repository\RelUsersWidgets;

use App\Entity\RelUsersWidgets\RelUserWidget;
use App\Entity\Users\User;
use App\Entity\Widgets\Widget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method RelUserWidget|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelUserWidget|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelUserWidget[]    findAll()
 * @method RelUserWidget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelUserWidgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelUserWidget::class);
    }

    public function findByUserIDAndCurrentRoleID(array $params)
    {
        return $this->createQueryBuilder('relUW')
            ->leftJoin(User::class, 'u', Join::WITH, 'relUW.userID = u.id ')
            ->leftJoin(Widget::class, 'w', Join::WITH, 'relUW.widgetID = w.id')
            ->where('u.id  = :userID')
            ->andWhere('w.roleID  = :currentRoleID')
            ->setParameter('userID', $params['userID'])
            ->setParameter('currentRoleID', $params['currentRoleID'])
            ->orderBy('relUW.position', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
