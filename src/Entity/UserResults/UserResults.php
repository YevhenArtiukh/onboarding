<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:08
 */

namespace App\Entity\UserResults;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;

interface UserResults
{
    public function add(UserResult $userResult);

    public function delete(UserResult $userResult);

    /**
     * @param OnboardingTraining $onboardingTraining
     * @param User $user
     * @return UserResult|null
     */
    public function findOneByOnboardingTrainingAndUser(OnboardingTraining $onboardingTraining, User $user);
}