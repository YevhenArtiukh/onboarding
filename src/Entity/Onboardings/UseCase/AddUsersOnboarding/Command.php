<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:25
 */

namespace App\Entity\Onboardings\UseCase\AddUsersOnboarding;


use App\Entity\Onboardings\Onboarding;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $users;
    private $onboarding;
    private $responder;

    public function __construct(
        ArrayCollection $users,
        Onboarding $onboarding
    )
    {
        $this->users = $users;
        $this->onboarding = $onboarding;
        $this->responder = new NullResponder();
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * @return Onboarding
     */
    public function getOnboarding(): Onboarding
    {
        return $this->onboarding;
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