<?php


namespace App\Entity\TrainingAttachments\UseCase\DeleteTrainingAttachment;


use App\Entity\TrainingAttachments\TrainingAttachment;

class Command
{
    private $trainingAttachment;
    private $responder;


    public function __construct(
        TrainingAttachment $trainingAttachment
    )
    {
        $this->trainingAttachment = $trainingAttachment;
        $this->responder = new NullResponder();
    }

    /**
     * @return TrainingAttachment
     */
    public function getTrainingAttachment(): TrainingAttachment
    {
        return $this->trainingAttachment;
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