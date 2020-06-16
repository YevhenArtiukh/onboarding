<?php


namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\ChangePhotoUser\Command;
use App\Entity\Users\Users;

class ChangePhotoUser
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

        $existingUser = $command->getUser();

        $existingUser->setPhoto($command->getPhoto()->move());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}