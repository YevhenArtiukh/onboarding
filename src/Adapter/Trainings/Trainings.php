<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:18
 */

namespace App\Adapter\Trainings;

use App\Entity\Trainings\Training;
use App\Entity\Trainings\Trainings as TrainingsInterface;
use Doctrine\ORM\EntityManager;

class Trainings implements TrainingsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Training $training)
    {
        $this->entityManager->persist($training);
    }

    public function delete(Training $training)
    {
        $this->entityManager->remove($training);
    }

    /**
     * @param int $id
     * @return Training|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Training::class)->findOneBy([
            'id' => $id
        ]);
    }
}