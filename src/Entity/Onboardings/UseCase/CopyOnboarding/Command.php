<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-20
 * Time: 15:12
 */

namespace App\Entity\Onboardings\UseCase\CopyOnboarding;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;

class Command
{
    private $onboarding;
    private $lastOnboarding;
    private $division;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        ?Onboarding $lastOnboarding,
        Division $division
    )
    {
        $this->onboarding = $onboarding;
        $this->lastOnboarding = $lastOnboarding;
        $this->division = $division;
        $this->responder = new NullResponder();
    }

    /**
     * @return Onboarding
     */
    public function getOnboarding(): Onboarding
    {
        return $this->onboarding;
    }

    /**
     * @return Onboarding|null
     */
    public function getLastOnboarding(): ?Onboarding
    {
        return $this->lastOnboarding;
    }

    /**
     * @return Division
     */
    public function getDivision(): Division
    {
        return $this->division;
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