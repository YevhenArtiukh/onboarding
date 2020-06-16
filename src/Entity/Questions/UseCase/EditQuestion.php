<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-06
 * Time: 12:49
 */

namespace App\Entity\Questions\UseCase;


use App\Core\Transaction;
use App\Entity\Answers\Answer;
use App\Entity\Answers\Answers;
use App\Entity\Questions\Questions;
use App\Entity\Questions\UseCase\EditQuestion\Command;

class EditQuestion
{
    private $questions;
    private $answers;
    private $transaction;

    public function __construct(
        Questions $questions,
        Answers $answers,
        Transaction $transaction
    )
    {
        $this->questions = $questions;
        $this->answers = $answers;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingQuestion = $this->questions->findOneById($command->getId());

        if(!$existingQuestion) {
            $command->getResponder()->questionNotFound();
            return;
        }

        foreach ($this->answers->findByQuestion($existingQuestion) as $answer) {
            $this->answers->delete($answer);
        }

        $existingQuestion->edit(
            $command->getName(),
            $command->getType()
        );

        if($command->getAnswers()) {
            foreach ($command->getAnswers() as $answer) {
                $answer = new Answer(
                    $answer['answer'],
                    $answer['correct'],
                    $existingQuestion
                );
                $this->answers->add($answer);
            }
        }

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->questionEdited();
    }
}