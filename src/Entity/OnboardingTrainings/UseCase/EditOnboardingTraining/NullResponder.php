<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:21
 */

namespace App\Entity\OnboardingTrainings\UseCase\EditOnboardingTraining;


final class NullResponder implements Responder
{

    public function onboardingTrainingNotFound()
    {

    }

    public function onboardingTrainingEdited()
    {

    }

    public function conflictTrainings()
    {

    }
}