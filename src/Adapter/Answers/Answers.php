<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 16:07
 */

namespace App\Adapter\Answers;

use App\Entity\Answers\Answer;
use App\Entity\Answers\Answers as AnswersInteface;
use App\Entity\Questions\Question;
use Doctrine\ORM\EntityManager;

class Answers implements AnswersInteface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Answer $answer)
    {
        $this->entityManager->persist($answer);
    }

    public function delete(Answer $answer)
    {
        $this->entityManager->remove($answer);
    }

    /**
     * @param int $id
     * @return Answer|null
     */
    public function findOneById(int $id)
    {
        return $this->entityManager->getRepository(Answer::class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param Question $question
     * @return mixed
     */
    public function findByQuestion(Question $question)
    {
        return $this->entityManager->getRepository(Answer::class)->findBy([
            'question' => $question
        ]);
    }
}