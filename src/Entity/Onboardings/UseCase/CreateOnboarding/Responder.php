<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:30
 */

namespace App\Entity\Onboardings\UseCase\CreateOnboarding;


interface Responder
{
    public function onboardingCreated();
}