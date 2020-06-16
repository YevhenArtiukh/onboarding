<?php


namespace App\Entity\TrainingAttachments\UseCase\AddTrainingAttachment;


use App\Adapter\Trainings\UploadedImage;
use App\Entity\Trainings\Training;

class Command
{
    private $training;
    private $file;
    private $originalName;
    private $responder;


    public function __construct(
        Training $training,
        string $originalName,
        UploadedImage $file
    )
    {
        $this->training = $training;
        $this->file = $file;
        $this->originalName = $originalName;
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
     * @return UploadedImage
     */
    public function getFile(): UploadedImage
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @return Responder
     */
    public function getResponder(): Responder
    {
        return $this->responder;
    }

    /**
     * @param Responder $responder
     */
    public function setResponder(Responder $responder): void
    {
        $this->responder = $responder;
    }


}