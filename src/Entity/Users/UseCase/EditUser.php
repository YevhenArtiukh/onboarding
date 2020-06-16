<?php


namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\EditUser\Command;
use App\Entity\Users\Users;

class EditUser
{
    private $users;
    private $transaction;

    public function __construct(
        Users $users,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingUser = $command->getUser();

        $existingUser->edit(
            $command->getName(),
            $command->getSurname(),
            $command->getEmail(),
            $command->getIdentifier(),
            $command->getDepartment(),
            $command->getPosition(),
            $command->getFormOfEmployment(),
            $command->getTypeOfWorker(),
            $command->getRoles(),
            $command->getDateOfEmployment()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userEdited();
    }
}