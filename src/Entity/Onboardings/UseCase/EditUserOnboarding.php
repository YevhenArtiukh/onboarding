<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-16
 * Time: 11:54
 */

namespace App\Entity\Onboardings\UseCase;


use App\Core\Transaction;
use App\Entity\Onboardings\UseCase\EditUserOnboarding\Command;
use App\Entity\Users\Users;

class EditUserOnboarding
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

        $existingUser = $this->users->findOneById($command->getId());

        if(!$existingUser) {
            $command->getResponder()->userNotFound();
            return;
        }

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
            $existingUser->getDateOfEmployment()
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