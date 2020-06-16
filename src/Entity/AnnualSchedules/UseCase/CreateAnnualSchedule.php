<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-05-14
 * Time: 12:49
 */

namespace App\Entity\AnnualSchedules\UseCase;


use App\Core\Transaction;
use App\Entity\AnnualSchedules\AnnualSchedule;
use App\Entity\AnnualSchedules\AnnualSchedules;
use App\Entity\AnnualSchedules\UseCase\CreateAnnualSchedule\Command;

class CreateAnnualSchedule
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

        $annualSchedule = new AnnualSchedule(
            $command->getDateStart(),
            $command->getDateEnd(),
            $command->getDays()
        );

        $this->annualSchedules->add($annualSchedule);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}