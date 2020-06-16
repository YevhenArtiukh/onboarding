<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:04
 */

namespace App\Entity\UserAnswers;


interface UserAnswers
{
    public function add(UserAnswer $userAnswer);

    public function delete(UserAnswer $userAnswer);
}