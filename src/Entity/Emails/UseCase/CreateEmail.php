<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-03-18
 * Time: 13:11
 */

namespace App\Entity\Emails\UseCase;


use App\Core\Transaction;
use App\Entity\Emails\Email;
use App\Entity\Emails\Emails;
use App\Entity\Emails\UseCase\CreateEmail\Command;

class CreateEmail
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

        $existingEmail = $this->emails->findOneByFunction($command->getFunction());

        if($existingEmail) {
            $command->getResponder()->emailExists();
            return;
        }

        $email = new Email(
            $command->getName(),
            $command->getCategory(),
            $command->getDays(),
            $command->getFunction(),
            $command->getSentTo(),
            $command->getMessage(),
            $command->getVariables()
        );

        $this->emails->add($email);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->emailCreated($command->getName());
    }
}