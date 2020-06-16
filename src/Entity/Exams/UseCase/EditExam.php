<?php


namespace App\Entity\Exams\UseCase;


use App\Core\Transaction;
use App\Entity\Exams\Exams;
use App\Entity\Exams\UseCase\EditExam\Command;

class EditExam
{
    private $exams;
    private $transaction;

    public function __construct(
        Exams $exams,
        Transaction $transaction
    )
    {
        $this->exams = $exams;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();
        $existingExam = $command->getExam();

        if($command->getStatus())
        {
            $currentActiveExam = $this->exams->findOneByTrainingIDAndActive($existingExam->getTraining());
            if($currentActiveExam)
                $currentActiveExam->changeActive();
        }


        $existingExam->edit(
            $command->getName(),
            $command->getDuration(),
            $command->getStatus()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}