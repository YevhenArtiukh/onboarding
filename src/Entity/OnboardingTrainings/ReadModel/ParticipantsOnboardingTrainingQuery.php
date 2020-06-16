<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-25
 * Time: 14:17
 */

namespace App\Entity\OnboardingTrainings\ReadModel;


use App\Entity\OnboardingTrainings\OnboardingTraining;

interface ParticipantsOnboardingTrainingQuery
{
    /**
     * @param OnboardingTraining $onboardingTraining
     * @return mixed
     */
    public function findAll(OnboardingTraining $onboardingTraining);
}