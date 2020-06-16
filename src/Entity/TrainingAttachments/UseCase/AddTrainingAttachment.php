<?php


namespace App\Entity\TrainingAttachments\UseCase;


use App\Core\Transaction;
use App\Entity\TrainingAttachments\TrainingAttachment;
use App\Entity\TrainingAttachments\TrainingAttachments;
use App\Entity\TrainingAttachments\UseCase\AddTrainingAttachment\Command;

class AddTrainingAttachment
{
    private $trainingAttachments;
    private $transaction;

    public function __construct(
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

        $trainingAttachment = new TrainingAttachment(
            $command->getOriginalName(),
            $command->getTraining()
        );

        $trainingAttachment->setName($command->getFile()->move());

        $this->trainingAttachments->add($trainingAttachment);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}