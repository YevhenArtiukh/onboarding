<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 13:32
 */

namespace App\Entity\AnnualSchedules\UseCase;


use App\Core\Transaction;
use App\Entity\AnnualSchedules\AnnualSchedules;
use App\Entity\AnnualSchedules\UseCase\DeleteAnnualSchedule\Command;

class DeleteAnnualSchedule
{
    private $annualSchedules;
    private $transaction;

    public function __construct(
        AnnualSchedules $annualSchedules,
        Transaction $transaction
    )
    {
        $this->annualSchedules = $annualSchedules;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $this->annualSchedules->delete($command->getAnnualSchedule());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}