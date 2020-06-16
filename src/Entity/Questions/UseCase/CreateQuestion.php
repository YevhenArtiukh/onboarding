<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-03
 * Time: 13:12
 */

namespace App\Entity\Questions\UseCase;


use App\Core\Transaction;
use App\Entity\Answers\Answer;
use App\Entity\Answers\Answers;
use App\Entity\Questions\Question;
use App\Entity\Questions\Questions;
use App\Entity\Questions\UseCase\CreateQuestion\Command;

class CreateQuestion
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
        if ($command->getAnswers()) {
            if (!($this->checkCorrectAnswer($command->getAnswers()))) {
                $command->getResponder()->correctAnswerNotExist();
                return;
            }
        }
        $this->transaction->begin();

        $sort = $this->questions->findLastInExam($command->getExam());

        $question = new Question(
            $command->getName(),
            $command->getType(),
            $sort ? $sort->getSort() + 1 : 1,
            $command->getExam()
        );

        $this->questions->add($question);


        if ($command->getAnswers()) {
            foreach ($command->getAnswers() as $data) {
                $answer = new Answer(
                    (string)$data['answer'],
                    (bool)$data['correct'],
                    $question
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

        $command->getResponder()->questionCreated();
    }

    private function checkCorrectAnswer(array $answers)
    {
        $correctAnswerArray = [];
        foreach ($answers as $answer) {
            $correctAnswerArray[] = $answer['correct'];
        }

        return in_array(true, $correctAnswerArray);
    }
}