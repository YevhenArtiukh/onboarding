<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 16:06
 */

namespace App\Entity\Onboardings\UseCase\ChangeStatusOnboarding;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;

class Command
{
    private $onboarding;
    private $division;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        Division $division
    )
    {
        $this->onboarding = $onboarding;
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