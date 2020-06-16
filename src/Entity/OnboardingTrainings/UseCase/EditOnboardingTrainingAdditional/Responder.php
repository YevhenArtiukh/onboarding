<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 13:08
 */

namespace App\Entity\OnboardingTrainings\UseCase\EditOnboardingTrainingAdditional;


interface Responder
{
    public function onboardingTrainingNotFound();
    public function onboardingTrainingEdited();
}