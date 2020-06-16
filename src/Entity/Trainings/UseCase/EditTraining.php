<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 10:39
 */

namespace App\Entity\Trainings\UseCase;


use App\Core\Transaction;
use App\Entity\Trainings\Trainings;
use App\Entity\Trainings\UseCase\EditTraining\Command;

class EditTraining
{
    private $trainings;
    private $transaction;

    public function __construct(
        Trainings $trainings,
        Transaction $transaction
    )
    {
        $this->trainings = $trainings;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingTraining = $command->getTraining();

        if(!$existingTraining)
            return;

        $existingTraining->edit(
            $command->getName(),
            $command->getTime(),
            $command->getTypeOfTraining(),
            $command->getKindOfTraining(),
            $command->getDescription(),
            $command->getTrainerInfo(),
            $command->getWorkerInfo(),
            $command->isAdditional(),
            $command->getDivision()
        );
        if($command->getImage())
            $existingTraining->setImage($command->getImage()->move());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}