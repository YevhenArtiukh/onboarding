<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 13:08
 */

namespace App\Entity\PresenceParticipants\UseCase\UserConfirmation;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;

class Command
{
    private $onboardingTraining;
    private $user;
    private $responder;

    public function __construct(
        OnboardingTraining $onboardingTraining,
        User $user
    )
    {
        $this->onboardingTraining = $onboardingTraining;
        $this->user = $user;
        $this->responder = new NullResponder();
    }

    /**
     * @return OnboardingTraining
     */
    public function getOnboardingTraining(): OnboardingTraining
    {
        return $this->onboardingTraining;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}