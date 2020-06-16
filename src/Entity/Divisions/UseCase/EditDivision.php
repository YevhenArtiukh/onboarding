<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:57
 */

namespace App\Entity\Divisions\UseCase;


use App\Core\Transaction;
use App\Entity\Divisions\Divisions;
use App\Entity\Divisions\UseCase\EditDivision\Command;

class EditDivision
{
    private $divisions;
    private $transaction;

    public function __construct(
        Divisions $divisions,
        Transaction $transaction
    )
    {
        $this->divisions = $divisions;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingDivision = $this->divisions->findOneById(
            $command->getId()
        );

        if(!$existingDivision)
            return;

        $existingDivision->edit(
            $command->getName(),
            $command->getMessageEmail()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}