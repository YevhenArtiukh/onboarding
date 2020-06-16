<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:17
 */

namespace App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining;


final class NullResponder implements Responder
{

    public function onboardingTrainingCreated()
    {

    }

    public function conflictTrainings()
    {

    }
}