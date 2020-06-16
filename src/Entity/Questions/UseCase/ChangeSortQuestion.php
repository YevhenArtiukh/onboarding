<?php


namespace App\Entity\Questions\UseCase;


use App\Core\Transaction;
use App\Entity\Questions\Question;
use App\Entity\Questions\Questions;
use App\Entity\Questions\UseCase\ChangeSortQuestion\Command;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChangeSortQuestion
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

        /** @var Question $currentQuestion */
        $currentQuestion = $this->questions->findOneById($command->getCurrentQuestionID());
        /** @var Question $toChangeQuestion */
        $toChangeQuestion = $this->questions->findOneById($command->getToChangeQuestionID());

        $currentSort = $currentQuestion->getSort();
        $toChangeSort = $toChangeQuestion->getSort();

        $currentQuestion->changeSort($toChangeSort);
        $toChangeQuestion->changeSort($currentSort);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        return new JsonResponse('success');
    }
}