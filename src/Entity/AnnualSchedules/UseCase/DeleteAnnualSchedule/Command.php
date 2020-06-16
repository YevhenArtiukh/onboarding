<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:32
 */

namespace App\Entity\AnnualSchedules\UseCase\DeleteAnnualSchedule;


use App\Entity\AnnualSchedules\AnnualSchedule;

class Command
{
    private $annualSchedule;
    private $responder;

    public function __construct(
        AnnualSchedule $annualSchedule
    )
    {
        $this->annualSchedule = $annualSchedule;
        $this->responder = new NullResponder();
    }

    /**
     * @return AnnualSchedule
     */
    public function getAnnualSchedule(): AnnualSchedule
    {
        return $this->annualSchedule;
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