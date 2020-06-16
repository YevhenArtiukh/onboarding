<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-10
 * Time: 14:25
 */

namespace App\Entity\Onboardings\UseCase;

use App\Core\Transaction;
use App\Entity\Onboardings\UseCase\AddUsersOnboarding\Command;
use App\Entity\Users\User;

class AddUsersOnboarding
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

        /**
         * @var User $user
         */
        foreach ($command->getUsers() as $user) {
            $user->setOnboarding($command->getOnboarding());
        }

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}