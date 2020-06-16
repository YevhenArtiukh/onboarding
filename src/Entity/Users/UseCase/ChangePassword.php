<?php


namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\ChangePassword\Command;

class ChangePassword
{

    private $transaction;

    public function __construct(
        Transaction $transaction
    )
    {
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $user = $command->getUser();

        $user->setPassword(
            password_hash($command->getPassword(), PASSWORD_BCRYPT)
        );
        $user->setActive(false);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}