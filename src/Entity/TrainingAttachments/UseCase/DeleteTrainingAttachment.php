<?php


namespace App\Entity\TrainingAttachments\UseCase;



use App\Core\Transaction;
use App\Entity\TrainingAttachments\TrainingAttachments;
use App\Entity\TrainingAttachments\UseCase\DeleteTrainingAttachment\Command;

class DeleteTrainingAttachment
{
    private $trainingAttachments;
    private $transaction;


    public function  __construct(
        TrainingAttachments $trainingAttachments,
        Transaction $transaction
    )
    {
        $this->trainingAttachments = $trainingAttachments;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $this->trainingAttachments->delete($command->getTrainingAttachment());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->trainingAttachmentDeleted();
    }

}