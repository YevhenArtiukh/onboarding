<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-09
 * Time: 13:21
 */

namespace App\Entity\OnboardingTrainings\UseCase\EditOnboardingTraining;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Trainings\Training;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $id;
    private $onboarding;
    private $training;
    private $division;
    private $coaches;
    private $type;
    private $time;
    private $day;
    private $responder;

    public function __construct(
        int $id,
        Onboarding $onboarding,
        Training $training,
        ?Division $division,
        PersistentCollection $coaches,
        string $type,
        \DateTimeInterface $time,
        int $day
    )
    {
        $this->id = $id;
        $this->onboarding = $onboarding;
        $this->training = $training;
        $this->division = $division;
        $this->coaches = $coaches;
        $this->type = $type;
        $this->time = $time;
        $this->day = $day;
        $this->responder = new NullResponder();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return PersistentCollection
     */
    public function getCoaches(): PersistentCollection
    {
        return $this->coaches;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTime(): \DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
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