<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 12:16
 */

namespace App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTraining;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Trainings\Training;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $onboarding;
    private $training;
    private $division;
    private $day;
    private $time;
    private $coaches;
    private $type;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        Training $training,
        ?Division $division,
        int $day,
        \DateTimeInterface $time,
        ?ArrayCollection $coaches,
        ?string $type
    )
    {
        $this->onboarding = $onboarding;
        $this->training = $training;
        $this->division = $division;
        $this->day = $day;
        $this->time = $time;
        $this->coaches = $coaches;
        $this->type = $type;
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
     * @return Training
     */
    public function getTraining(): Training
    {
        return $this->training;
    }

    /**
     * @return Division|null
     */
    public function getDivision(): ?Division
    {
        return $this->division;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTime(): \DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getCoaches(): ?ArrayCollection
    {
        return $this->coaches;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
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