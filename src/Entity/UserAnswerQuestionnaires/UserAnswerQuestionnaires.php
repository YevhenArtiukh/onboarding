<?php


namespace App\Entity\UserAnswerQuestionnaires;


interface UserAnswerQuestionnaires
{
    public function add(UserAnswerQuestionnaire $userAnswerQuestionnaire);

    public function delete(UserAnswerQuestionnaire $userAnswerQuestionnaire);
}