<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:30
 */

namespace App\Entity\Onboardings\UseCase\CreateOnboarding;


class Command
{
    private $days;
    private $responder;

    public function __construct(
        array $days
    )
    {
        $this->days = $days;
        $this->responder = new NullResponder();
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