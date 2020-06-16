<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:44
 */

namespace App\Adapter\Questions;

use App\Entity\Exams\Exam;
use App\Entity\Questions\Question;
use App\Entity\Questions\Questions as QuestionsInterface;
use Doctrine\ORM\EntityManager;

class Questions implements QuestionsInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Question $question)
    {
        $this->entityManager->persist($question);
    }

    public function delete(Question $question)
    {
        $this->entityManager->remove($question);
    }

    /**
     * @param int $id
     * @return Question|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Question::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param Exam $exam
     * @return Question|null
     */
    public function findLastInExam(Exam $exam)
    {
        return $this->entityManager->getRepository(Question::class)->findLastInExam(
            $exam
        );
    }
}