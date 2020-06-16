<?php


namespace App\Entity\Questions\UseCase;


use App\Core\Transaction;
use App\Entity\Questions\Questions;
use App\Entity\Questions\UseCase\DeleteQuestion\Command;

class DeleteQuestion
{
    private $questions;
    private $transaction;


    public function __construct(
        Questions $questions,
        Transaction $transaction
    )
    {
        $this->questions = $questions;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $this->questions->delete($command->getQuestion());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->questionDeleted();
    }
}