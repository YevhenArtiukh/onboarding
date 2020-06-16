<?php


namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\MigrateUser\Command;
use App\Entity\Users\Users;

class MigrateUser
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

        $currentUser = $command->getUser();
        if($this->users->findByEmailExceptUser($command->getEmail(), $currentUser))
        {
            $command->getResponder()->userWithEmailExist();
            $this->transaction->rollback();
            return ;
        }

        $currentUser->migrate(
            $command->getEmail(),
            $command->getDepartment(),
            $command->getPosition(),
            $command->getFormOfEmployment(),
            $command->getTypeOfWorker()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
        $command->getResponder()->userMigrated();
    }

}