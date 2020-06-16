<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-20
 * Time: 15:13
 */

namespace App\Entity\Onboardings\UseCase\CopyOnboarding;


interface Responder
{
    public function lastOnboardingNotFound();
    public function conflictTrainings();
    public function differentNumbersOfDays();
    public function onboardingCopied();
}