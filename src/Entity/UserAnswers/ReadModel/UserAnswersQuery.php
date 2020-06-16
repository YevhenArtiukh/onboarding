<?php


namespace App\Entity\UserAnswers\ReadModel;


use App\Entity\UserResults\UserResult;

interface UserAnswersQuery
{
    public function getAllByUserResult(UserResult $userResult);
}