<?php


namespace App\Adapter\UserAnswerQuestionnaires;

use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaires as UserAnswerQuestionnairesInterface;
use Doctrine\ORM\EntityManager;

class UserAnswerQuestionnaires implements UserAnswerQuestionnairesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function add(UserAnswerQuestionnaire $userAnswerQuestionnaire)
    {
        $this->entityManager->persist($userAnswerQuestionnaire);
    }

    public function delete(UserAnswerQuestionnaire $userAnswerQuestionnaire)
    {
        $this->entityManager->remove($userAnswerQuestionnaire);
    }
}