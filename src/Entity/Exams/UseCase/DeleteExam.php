<?php


namespace App\Entity\Exams\UseCase;


use App\Core\Transaction;
use App\Entity\Exams\Exams;
use App\Entity\Exams\UseCase\DeleteExam\Command;

class DeleteExam
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

        $this->exams->delete($command->getExam());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->examDeleted();
    }


}