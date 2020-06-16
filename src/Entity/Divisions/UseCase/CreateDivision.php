<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-17
 * Time: 16:44
 */

namespace App\Entity\Divisions\UseCase;


use App\Core\Transaction;
use App\Entity\Divisions\Division;
use App\Entity\Divisions\Divisions;
use App\Entity\Divisions\UseCase\CreateDivision\Command;

class CreateDivision
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

        $division = new Division(
            $command->getName(),
            $command->getMessageEmail()
        );

        $this->divisions->add($division);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}