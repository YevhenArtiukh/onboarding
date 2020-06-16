<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:43
 */

namespace App\Entity\OnboardingDivisions\UseCase\CreateOnboardingDivision;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;

class Command
{
    private $onboarding;
    private $division;
    private $days;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        Division $division,
        array $days
    )
    {
        $this->onboarding = $onboarding;
        $this->division = $division;
        $this->days = $days;
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
     * @return Division
     */
    public function getDivision(): Division
    {
        return $this->division;
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
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