<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:41
 */

namespace App\Entity\OnboardingTrainings\UseCase\DeleteOnboardingTraining;


interface Responder
{
    public function onboardingTrainingNotFound();
    public function onboardingTrainingDeleted();
}