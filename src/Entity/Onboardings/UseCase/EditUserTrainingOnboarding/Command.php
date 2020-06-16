<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 15:35
 */

namespace App\Entity\Onboardings\UseCase\EditUserTrainingOnboarding;

use App\Entity\Onboardings\Onboarding;
use App\Entity\Users\User;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $user;
    private $onboarding;
    private $onboardingTrainings;
    private $responder;

    public function __construct(
        User $user,
        Onboarding $onboarding,
        PersistentCollection $onboardingTrainings
    )
    {
        $this->user = $user;
        $this->onboarding = $onboarding;
        $this->onboardingTrainings = $onboardingTrainings;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Onboarding
     */
    public function getOnboarding(): Onboarding
    {
        return $this->onboarding;
    }

    /**
     * @return PersistentCollection
     */
    public function getOnboardingTrainings(): PersistentCollection
    {
        return $this->onboardingTrainings;
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