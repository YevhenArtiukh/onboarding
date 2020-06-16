<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-17
 * Time: 13:08
 */

namespace App\Entity\OnboardingTrainings\UseCase\EditOnboardingTrainingAdditional;


use App\Entity\Divisions\Division;
use App\Entity\Onboardings\Onboarding;
use App\Entity\Trainings\Training;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $id;
    private $training;
    private $coaches;
    private $type;
    private $day;
    private $responder;

    public function __construct(
        int $id,
        Training $training,
        PersistentCollection $coaches,
        string $type,
        int $day
    )
    {
        $this->id = $id;
        $this->training = $training;
        $this->coaches = $coaches;
        $this->type = $type;
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
     * @return Training
     */
    public function getTraining(): Training
    {
        return $this->training;
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