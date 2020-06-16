<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 12:49
 */

namespace App\Entity\AnnualSchedules\UseCase\CreateAnnualSchedule;


class Command
{
    private $dateStart;
    private $dateEnd;
    private $days;
    private $responder;

    public function __construct(
        \DateTime $dateStart,
        \DateTime $dateEnd,
        array $days
    )
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->days = $days;
        $this->responder = new NullResponder();
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