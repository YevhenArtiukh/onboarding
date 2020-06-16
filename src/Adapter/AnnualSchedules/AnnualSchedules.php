<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-13
 * Time: 15:20
 */

namespace App\Adapter\AnnualSchedules;

use App\Entity\AnnualSchedules\AnnualSchedule;
use App\Entity\AnnualSchedules\AnnualSchedules as AnnualSchedulesInterface;
use Doctrine\ORM\EntityManager;

class AnnualSchedules implements AnnualSchedulesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(AnnualSchedule $annualSchedule)
    {
        $this->entityManager->persist($annualSchedule);
    }

    public function delete(AnnualSchedule $annualSchedule)
    {
        $this->entityManager->remove($annualSchedule);
    }

    /**
     * @param int $id
     * @return AnnualSchedule|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(AnnualSchedule::class)->findOneBy([
            'id' => $id
        ]);
    }
}