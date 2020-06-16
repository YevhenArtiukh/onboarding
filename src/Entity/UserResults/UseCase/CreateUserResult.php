<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-04-24
 * Time: 12:12
 */

namespace App\Entity\UserResults\UseCase;


use App\Core\Transaction;
use App\Entity\UserAnswers\UserAnswer;
use App\Entity\UserAnswers\UserAnswers;
use App\Entity\UserResults\UseCase\CreateUserResult\Command;
use App\Entity\UserResults\UserResult;
use App\Entity\UserResults\UserResults;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateUserResult
{
    private $userResults;
    private $userAnswers;
    private $transaction;

    public function __construct(
        UserResults $userResults,
        UserAnswers $userAnswers,
        Transaction $transaction
    )
    {
        $this->userResults = $userResults;
        $this->userAnswers = $userAnswers;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        if (!empty($command->getAnswers())) {
            foreach ($command->getAnswers()['answers'] as $idQuestion => $answers) {
                $givenAnswers[$idQuestion] = array_keys($answers);
            }
        }
            $userResult = new UserResult(
                $command->getUser(),
                $command->getOnboardingTraining(),
                0
            );


        foreach ($command->getExam()->getQuestions() as $question) {
            foreach ($question->getAnswers() as $answer) {
                if ($answer->getCorrect()) {
                    $currentAnswers[$question->getId()][] = $answer->getId();
                }

                if(in_array($question->getId(), array_keys($givenAnswers??[])) && in_array($answer->getId(),$givenAnswers[$question->getId()]??[])) {
                    $userAnswer = new UserAnswer(
                        $command->getUser(),
                        $userResult,
                        $question->getName(),
                        $answer->getName(),
                        $answer->getCorrect()
                    );

                    $this->userAnswers->add($userAnswer);
                }
            }
        }

        $count = 0;

        foreach ($currentAnswers??[] as $idQuestion => $correctAnswers) {
            if(isset($givenAnswers) && isset($givenAnswers[$idQuestion]) && $correctAnswers === $givenAnswers[$idQuestion])
                $count++;
        }

        $score = ($count*100/count($currentAnswers??[0]));

        $userResult->setScore($score);
        $this->userResults->add($userResult);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        return new JsonResponse([
            'score'=>(int)$score,
            'count'=>$count,
            'correctCount'=>count($currentAnswers??[0])
        ]);
    }
}