<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:05
 */

namespace App\Adapter\UserAnswers;

use App\Entity\UserAnswers\UserAnswer;
use App\Entity\UserAnswers\UserAnswers as UserAnswersInterface;
use Doctrine\ORM\EntityManager;

class UserAnswers implements UserAnswersInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(UserAnswer $userAnswer)
    {
        $this->entityManager->persist($userAnswer);
    }

    public function delete(UserAnswer $userAnswer)
    {
        $this->entityManager->remove($userAnswer);
    }
}