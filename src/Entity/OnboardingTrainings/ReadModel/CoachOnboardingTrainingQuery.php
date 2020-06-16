<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 12:16
 */

namespace App\Entity\OnboardingTrainings\ReadModel;


use App\Entity\Users\User;

interface CoachOnboardingTrainingQuery
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findAll(User $user);
}