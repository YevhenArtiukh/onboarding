<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:03
 */

namespace App\Entity\PresenceParticipants;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;

interface PresenceParticipants
{
    public function add(PresenceParticipant $presenceParticipant);

    /**
     * @param OnboardingTraining $onboardingTraining
     * @param User $user
     * @return PresenceParticipant|null
     */
    public function findOneByOnboardingTrainingAndUser(OnboardingTraining $onboardingTraining, User $user);
}