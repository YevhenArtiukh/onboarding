<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-26
 * Time: 15:02
 */

namespace App\Entity\PresenceParticipants\UseCase\CoachConfirmation;


use App\Entity\OnboardingTrainings\OnboardingTraining;
use App\Entity\Users\User;

class Command
{
    private $onboardingTraining;
    private $users;
    private $coach;
    private $responder;

    public function __construct(
        OnboardingTraining $onboardingTraining,
        array $users,
        User $coach
    )
    {
        $this->onboardingTraining = $onboardingTraining;
        $this->users = $users;
        $this->coach = $coach;
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
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return User
     */
    public function getCoach(): User
    {
        return $this->coach;
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