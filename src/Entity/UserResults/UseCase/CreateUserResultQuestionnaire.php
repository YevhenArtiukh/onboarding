<?php


namespace App\Entity\UserResults\UseCase;


use App\Core\Transaction;
use App\Entity\Questions\Question;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaire;
use App\Entity\UserAnswerQuestionnaires\UserAnswerQuestionnaires;
use App\Entity\UserResults\UseCase\CreateUserResultQuestionnaire\Command;
use App\Entity\UserResults\UserResult;
use App\Entity\UserResults\UserResults;

class CreateUserResultQuestionnaire
{
    private $userResults;
    private $userAnswerQuestionnaires;

    private $transaction;

    public function __construct(
        UserResults $userResults,
        UserAnswerQuestionnaires $userAnswerQuestionnaires,
        Transaction $transaction)
    {
        $this->userResults = $userResults;
        $this->userAnswerQuestionnaires = $userAnswerQuestionnaires;
        $this->transaction = $transaction;
    }


    public function execute(Command $command)
    {
        $this->transaction->begin();

        $questionArray = [];
        /** @var Question $question */
        foreach ($command->getExam()->getQuestions() as $question)
        {
            $questionArray[$question->getId()] = [
                'name' => $question->getName(),
                'type' => $question->getType()
            ];
        }
        $userResult = new UserResult(
            $command->getUser(),
            $command->getOnboardingTraining(),
            100
        );
        $this->userResults->add($userResult);

        foreach ($command->getAnswers() as $key => $answer)
        {
            $userResultQuestionnaire = new UserAnswerQuestionnaire(
                $command->getUser(),
                $userResult,
                $questionArray[$key]['name'],
                $questionArray[$key]['type'],
                $answer
            );

            $this->userAnswerQuestionnaires->add($userResultQuestionnaire);
        }

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userResultQuestionnaireCreated();
    }


}