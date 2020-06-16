<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 14:27
 */

namespace App\Entity\AnnualSchedules\UseCase\EditAnnualSchedule;


use App\Entity\AnnualSchedules\AnnualSchedule;

class Command
{
    private $annualSchedule;
    private $dateStart;
    private $dateEnd;
    private $days;
    private $responder;

    public function __construct(
        AnnualSchedule $annualSchedule,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        array $days
    )
    {
        $this->annualSchedule = $annualSchedule;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->days = $days;
        $this->responder = new NullResponder();
    }

    /**
     * @return AnnualSchedule
     */
    public function getAnnualSchedule(): AnnualSchedule
    {
        return $this->annualSchedule;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
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