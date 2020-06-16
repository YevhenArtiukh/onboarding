<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-27
 * Time: 13:42
 */

namespace App\Entity\Onboardings\UseCase\SendEmailOnboarding;


use App\Entity\Onboardings\Onboarding;

class Command
{
    private $onboarding;
    private $responder;

    public function __construct(
        Onboarding $onboarding
    )
    {
        $this->onboarding = $onboarding;
        $this->responder = new NullResponder();
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