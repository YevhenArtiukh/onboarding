<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 12:13
 */

namespace App\Entity\Exams\UseCase;


use App\Core\Transaction;
use App\Entity\Exams\Exam;
use App\Entity\Exams\Exams;
use App\Entity\Exams\UseCase\CreateExam\Command;

class CreateExam
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

        if($command->isStatus())
        {
            $currentActiveExam = $this->exams->findOneByTrainingIDAndActive($command->getTraining());
            if($currentActiveExam)
                $currentActiveExam->changeActive();
        }
        $exam = new Exam(
            $command->getName(),
            $command->getType(),
            $command->getDuration(),
            $command->isStatus(),
            $command->getTraining()
        );

        $this->exams->add($exam);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}