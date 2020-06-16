<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 12:35
 */

namespace App\Entity\OnboardingTrainings\UseCase\CreateOnboardingTrainingAdditional;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Trainings\Training;
use Doctrine\Common\Collections\ArrayCollection;

class Command
{
    private $onboarding;
    private $training;
    private $division;
    private $type;
    private $coaches;
    private $day;
    private $responder;

    public function __construct(
        Onboarding $onboarding,
        Training $training,
        Division $division,
        string $type,
        ArrayCollection $coaches,
        int $day
    )
    {
        $this->onboarding = $onboarding;
        $this->training = $training;
        $this->division = $division;
        $this->type = $type;
        $this->coaches = $coaches;
        $this->day = $day;
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
     * @return Division
     */
    public function getDivision(): Division
    {
        return $this->division;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ArrayCollection
     */
    public function getCoaches(): ArrayCollection
    {
        return $this->coaches;
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