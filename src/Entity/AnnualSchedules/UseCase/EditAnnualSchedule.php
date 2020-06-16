<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 14:27
 */

namespace App\Entity\AnnualSchedules\UseCase;


use App\Core\Transaction;
use App\Entity\AnnualSchedules\AnnualSchedules;
use App\Entity\AnnualSchedules\UseCase\EditAnnualSchedule\Command;

class EditAnnualSchedule
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

        $command->getAnnualSchedule()->edit(
            $command->getDateStart(),
            $command->getDateEnd(),
            $command->getDays()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}