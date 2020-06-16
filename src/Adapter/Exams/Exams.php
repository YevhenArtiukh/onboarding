<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 11:58
 */

namespace App\Adapter\Exams;

use App\Entity\Exams\Exam;
use App\Entity\Exams\Exams as ExamsInterface;
use App\Entity\Trainings\Training;
use Doctrine\ORM\EntityManager;

class Exams implements ExamsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Exam $exam)
    {
        $this->entityManager->persist($exam);
    }

    public function delete(Exam $exam)
    {
        $this->entityManager->remove($exam);
    }

    /**
     * @param int $id
     * @return Exam|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Exam::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function findOneByTrainingIDAndActive(Training $training)
    {
        return $this->entityManager->getRepository(Exam::class)->findOneBy([
            'training' => $training,
            'isActive' => true
        ]);
    }
}