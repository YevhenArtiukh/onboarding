<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:40
 */

namespace App\Entity\Trainings\UseCase\EditTraining;


use App\Adapter\Trainings\UploadedImage;
use App\Entity\Trainings\Training;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class Command
{
    private $training;
    private $name;
    private $time;
    private $typeOfTraining;
    private $kindOfTraining;
    private $description;
    private $trainerInfo;
    private $workerInfo;
    private $isAdditional;
    private $division;
    private $image;
    private $responder;

    public function __construct(
        Training $training,
        string $name,
        int $time,
        string $typeOfTraining,
        string $kindOfTraining,
        ?string $description,
        ?string $trainerInfo,
        ?string $workerInfo,
        bool $isAdditional,
        $division,
        ?UploadedImage $image
    )
    {
        $this->training = $training;
        $this->name = $name;
        $this->time = $time;
        $this->typeOfTraining = $typeOfTraining;
        $this->kindOfTraining = $kindOfTraining;
        $this->description = $description;
        $this->trainerInfo = $trainerInfo;
        $this->workerInfo = $workerInfo;
        $this->isAdditional = $isAdditional;
        $this->division = $division;
        $this->image = $image;
        $this->responder = new NullResponder();
    }

    /**
     * @return Training
     */
    public function getTraining(): Training
    {
        return $this->training;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTypeOfTraining(): string
    {
        return $this->typeOfTraining;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return UploadedImage|null
     */
    public function getImage(): ?UploadedImage
    {
        return $this->image;
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

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getKindOfTraining(): string
    {
        return $this->kindOfTraining;
    }

    /**
     * @return string|null
     */
    public function getTrainerInfo(): ?string
    {
        return $this->trainerInfo;
    }

    /**
     * @return string|null
     */
    public function getWorkerInfo(): ?string
    {
        return $this->workerInfo;
    }

    /**
     * @return bool
     */
    public function isAdditional(): bool
    {
        return $this->isAdditional;
    }


    public function getDivision()
    {
        return $this->division;
    }



}