<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-30
 * Time: 13:27
 */

namespace App\Entity\Emails\UseCase;


use App\Core\Transaction;
use App\Entity\Emails\Emails;
use App\Entity\Emails\UseCase\EditEmail\Command;

class EditEmail
{
    private $emails;
    private $transaction;

    public function __construct(
        Emails $emails,
        Transaction $transaction
    )
    {
        $this->emails = $emails;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingEmail = $this->emails->findOneById($command->getId());

        if(!$existingEmail) {
            $command->getResponder()->emailNotFound();
            return;
        }

        $existingEmail->edit(
            $command->getName(),
            $command->getDays(),
            $command->getSentTo(),
            $command->getMessage()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->emailEdited();
    }
}